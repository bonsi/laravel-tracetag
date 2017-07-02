<?php declare(strict_types=1);

use Bonsi\TraceTag\TraceTag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Bonsi\TraceTag\TraceTagServiceProvider;
use Bonsi\TraceTag\Middleware\TraceTagMiddleware;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TraceTagMiddlewareTest extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [TraceTagServiceProvider::class];
    }

    /** @test */
    function it_should_set_the_trace_tag_provided_by_header()
    {
        $response = new Response;
        $traceTagHeaderName = config('trace-tag.middleware.header-name');
        $traceTagHeaderValue = 'TRACE_TAG_FROM_HEADER';
        $headers = [
            'HTTP_'.$traceTagHeaderName => $traceTagHeaderValue
        ];
        $request = Request::create('http://example.com/trace-me', 'GET', [], [], [], $headers);
        $traceTag = app()->make(TraceTag::class);

        // Pass it to the middleware
        $middleware = new TraceTagMiddleware($traceTag);
        $middleware->handle($request, function () use ($response) {
            return $response;
        });

        $this->assertEquals($traceTagHeaderValue, $traceTag->tag());
    }

    /** @test */
    function it_should_set_the_trace_tag_provided_by_the_input_field()
    {
        $response = new Response;
        $traceTagInputName = config('trace-tag.middleware.input-name');
        $traceTagInputValue = 'TRACE_TAG_FROM_INPUT';

        $request = Request::create('http://example.com/trace-me?'.$traceTagInputName.'='.$traceTagInputValue, 'GET');
        $traceTag = app()->make(TraceTag::class);

        // Pass it to the middleware
        $middleware = new TraceTagMiddleware($traceTag);
        $middleware->handle($request, function () use ($response) {
            return $response;
        });

        $this->assertEquals($traceTagInputValue, $traceTag->tag());
    }

    /** @test */
    function it_should_give_priority_to_the_tag_set_by_the_header()
    {
        $response = new Response;
        $traceTagHeaderName = config('trace-tag.middleware.header-name');
        $traceTagHeaderValue = 'TRACE_TAG_FROM_HEADER';
        $headers = [
            'HTTP_'.$traceTagHeaderName => $traceTagHeaderValue
        ];
        $traceTagInputName = config('trace-tag.middleware.input-name');
        $traceTagInputValue = 'TRACE_TAG_FROM_INPUT';
        $request = Request::create('http://example.com/trace-me?'.$traceTagInputName.'='.$traceTagInputValue, 'GET', [], [], [], $headers);
        $traceTag = app()->make(TraceTag::class);

        // Pass it to the middleware
        $middleware = new TraceTagMiddleware($traceTag);
        $middleware->handle($request, function () use ($response) {
            return $response;
        });

        $this->assertNotEquals($traceTagInputValue, $traceTag->tag());
        $this->assertEquals($traceTagHeaderValue, $traceTag->tag());
    }

}