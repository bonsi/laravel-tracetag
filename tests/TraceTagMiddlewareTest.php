<?php declare(strict_types=1);

use Bonsi\TraceTag\TraceTag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Bonsi\TraceTag\TraceTagServiceProvider;
use Bonsi\TraceTag\Middleware\TraceTagMiddleware;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TraceTagMiddlewareTest extends OrchestraTestCase
{

    /** @test */
    function it_should_set_the_trace_tag_response_header()
    {
        $traceTagHeaderValue = 'TRACE_TAG_RETURNED_IN_HEADER';
        $traceTag = app()->make(TraceTag::class);
        $traceTag->setTag($traceTagHeaderValue);

        $request = Request::create('http://example.com/trace-me', 'GET');
        $middleware = new TraceTagMiddleware($traceTag);
        $response = new Response;

        // Pass it to the middleware
        $middlewareResponse = $middleware->handle($request, function () use ($response) {
            return $response;
        });

        $this->assertTrue($middlewareResponse->headers->contains($this->getHeaderName(), $traceTagHeaderValue));
    }

    /** @test */
    function it_should_set_the_trace_tag_provided_by_header()
    {
        $traceTagHeaderValue = 'TRACE_TAG_FROM_HEADER';
        $headers = [
            'HTTP_'.$this->getHeaderName() => $traceTagHeaderValue
        ];
        $request = Request::create('http://example.com/trace-me', 'GET', [], [], [], $headers);
        $traceTag = app()->make(TraceTag::class);
        $middleware = new TraceTagMiddleware($traceTag);
        $response = new Response;

        // Pass it to the middleware
        $middleware->handle($request, function () use ($response) {
            return $response;
        });

        $this->assertEquals($traceTagHeaderValue, $traceTag->tag());
    }

    /** @test */
    function it_should_set_the_trace_tag_provided_by_the_input_field()
    {
        $traceTagInputValue = 'TRACE_TAG_FROM_INPUT';
        $request = Request::create(
            'http://example.com/trace-me?'.$this->getInputName().'='.$traceTagInputValue, 'GET'
        );
        $traceTag = app()->make(TraceTag::class);
        $middleware = new TraceTagMiddleware($traceTag);
        $response = new Response;

        // Pass it to the middleware
        $middleware->handle($request, function () use ($response) {
            return $response;
        });

        $this->assertEquals($traceTagInputValue, $traceTag->tag());
    }

    /** @test */
    function it_should_give_priority_to_the_tag_set_by_the_header()
    {
        $traceTagHeaderValue = 'TRACE_TAG_FROM_HEADER';
        $headers = [
            'HTTP_'.$this->getHeaderName() => $traceTagHeaderValue
        ];
        $traceTagInputValue = 'TRACE_TAG_FROM_INPUT';
        $request = Request::create(
            'http://example.com/trace-me?'.$this->getInputName().'='.$traceTagInputValue,
            'GET', [], [], [], $headers
        );
        $traceTag = app()->make(TraceTag::class);
        $middleware = new TraceTagMiddleware($traceTag);
        $response = new Response;

        // Pass it to the middleware
        $middleware->handle($request, function () use ($response) {
            return $response;
        });

        $this->assertNotEquals($traceTagInputValue, $traceTag->tag());
        $this->assertEquals($traceTagHeaderValue, $traceTag->tag());
    }

    protected function getPackageProviders($app)
    {
        return [TraceTagServiceProvider::class];
    }

    private function getHeaderName()
    {
        return config('trace-tag.middleware.header-name');
    }

    private function getInputName()
    {
        return config('trace-tag.middleware.input-name');
    }

}