# Laravel TraceTag
[![Build Status](https://travis-ci.org/bonsi/laravel-tracetag.svg?branch=master)](https://travis-ci.org/bonsi/laravel-tracetag)
---

Generate an unique tag or identifier (aka TraceTag) for an application request to be tracked through your application.

Add it to your application logs or wherever to get a better overview which logged information belongs to the same request.

A monolog processor to add the TraceTag to your logs is included out of the box.

Mind you, this is still very much a work in progress!

Only tested with Laravel 5.4 currently.

### Use cases

* **Ability to aggregate all logs belonging to a specific request**

	This is exactly what the TraceTag core functionality is about: having a unique identifier available for a _single request_. TraceTag has no knowledge of the client, and will therefore generate a new tag on the next request. 

* **Ability to aggregate all logs belonging to a specific client**
	
	This requires some work on your part as well: you will have to tell TraceTag which tag to use on subsequent requests from the same client. 
	
	A middleware (disabled by default) is included in the package to help you with that. It allows for setting the TraceTag from the outside using either a HTTP Header (default: "X-Trace-Tag") or an input field (default: "_trace_tag").
	The TraceTag library will then store the provided value and ```TraceTag::tag();``` will return that value on subsequent calls (within the same HTTP request that is).
	
	The middleware will also attach a HTTP header to the response ("X-Trace-Tag"). It's your job to include the returned X-Trace-Tag value on the next HTTP request from the client. In doing so, the same TraceTag can be traced over multiple HTTP requests for the same client.

	You can either let the TraceTag library generate such a tag using a Generator for you the first time, or ofcourse, provide your own.

### Usage

* Generate & get the TraceTag:

	If no TraceTag has been set or generated, a call to the ```tag()``` will generate one for you using the configured generator. The same TraceTag will then be returned for every subsequent call to the ```tag()``` method.
		
		$tag = app()->make(Bonsi\TraceTag\TraceTag::class)->tag();
		$tag = TraceTag::tag();
		
* Set the TraceTag:

	This value will then be returned on subsequent calls to the ```tag()``` method.
 
	 	TraceTag::setTag('MY-CUSTOM-TAG');

	
	
You can also set the TraceTag from the outside to, for example, provide an unique tag across requests. The included included middleware can with that.
	 

### Install
* Since the package is still in development, make sure you add the following to your ```composer.json```:

		"minimum-stability": "dev",


* Add the package to your composer.json

		composer require bonsi/laravel-tracetag
* Update composer

		composer update
* Add the ServiceProvider to your app/config.php

		'providers' => [
			...
			/*
			 * Package Service Providers...
			 */
			Bonsi\TraceTag\TraceTagServiceProvider::class,
			...

* Some of the generators require an additional composer package
  * RandomInt: _no extra package required_
  * Uuid4: ~~ramsey/uuid@~3.0~~ This dependency is now defined as required. Although it's 
  only required if one were to use the Uuid4Generator, adding the dependency as an "optional" 
  dependency in for example composer's "suggests" list doesn't feel right. The way to go 
  here would be to extract the generators in this package to their own composer package so that the
  dependencies per generator could be specified in their own composer.json. But, since the generators
  are barely 10 lines of code, this would be an overkill at the moment in my opinion.
  
  
			
* Publish the configuration file
	
	Get your own customizable config file if you want to change the default settings:

		php artisan vendor:publish --provider="Bonsi\TraceTag\TraceTagServiceProvider"
			
	This will copy a customizable config file to ```config/tracetag.php```.

### Concepts
- **Generator**: A class responsible for generating a TraceTag. Included: Uuid4 & RandomInt.
	
	Example generator tags:
    - RandomInt: 9208221171113638741
    - Uuid4: 857fac7b-1a0a-491b-9235-5214e6819351
    - _or: brew your own (by implementing the Generator interface)_

- **Integration**: A class responsible for injecting the TraceTag into various other parts of your application. Included: a Monolog processor to add the TraceTag to your logs.

### Todo's:
- [X] Add middleware for adding a TraceTag as a header
- [X] Add a facade
- [ ] Add tests
- [ ] Add more generators
- [ ] Add more integrations


### Integrations

#### Monolog

Adding the TraceTag to your monolog logger is already enabled by default. The TraceTag will be added to monolog's 'extra' field.
