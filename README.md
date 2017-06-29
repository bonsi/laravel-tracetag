# Laravel TraceTag
---

Generate an unique tag or identifier (aka TraceTag) for an application request to be tracked through your application.

Add it to your application logs or wherever to get a better overview which logged information belongs to the same request.

A monolog processor to add the TraceTag to your logs is included out of the box.

Mind you, this is still very much a work in progress!

**Example tags:**
- RandomInt: 9208221171113638741
- Uuid4: 857fac7b-1a0a-491b-9235-5214e6819351

### Install
* Add the package to your composer.json:

		composer require bonsi/laravel-tracetag
* Run composer update:

		composer update
* Add the ServiceProvider to your app/config.php:

		'providers' => [
			...
			/*
			 * Package Service Providers...
			 */
			Bonsi\TraceTag\TraceTagServiceProvider::class,
			...

* Some of the generators require an extra composer package:
	* RandomInt: _no extra package required_
	* Uuid4:
	
			composer require ramsey/uuid@~3.0
			

### Concepts
- **Generator**: A class responsible for generating a TraceTag. Included: Uuid4 & RandomInt.
- **Integration**: A class responsible for injecting the TraceTag into various other parts of your application. Included: a Monolog processor to add the TraceTag to your logs.

### Todo's:
- [ ] Add middleware for adding a TraceTag as a header
- [ ] Add tests
- [ ] Add more generators
- [ ] Add more integrations


### Integrations

#### Monolog

To add the TraceTag to your monolog logger, add the following to bootstrap/app.php:

	$app->configureMonologUsing(function ($monolog) {
		$monolog->pushProcessor(new Bonsi\TraceTag\Integrations\MonologProcessor);
	});


