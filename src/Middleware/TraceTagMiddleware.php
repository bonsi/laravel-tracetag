<?php declare(strict_types=1);

namespace Bonsi\TraceTag\Middleware;

use Closure;
use Bonsi\TraceTag\TraceTag;

/*
 * TraceTag Middleware
 *
 * @package Bonsi\TraceTag
 */
class TraceTagMiddleware
{
    protected $traceTag;

    /**
     * TraceTag Middleware constructor.
     *
     * @param $traceTag
     */
    public function __construct(TraceTag $traceTag)
    {
        $this->traceTag = $traceTag;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headerName = config('trace-tag.middleware.header-name', 'X-Trace-Tag');
        $inputName = config('trace-tag.middleware.input-name', '_tracetag');

        if($request->has($inputName))
        {
            $this->traceTag->setTag($request->get($inputName));
        }
        if($request->hasHeader($headerName))
        {
            $this->traceTag->setTag($request->header($headerName));
        }

        $response = $next($request);

        // Do note that echo'ing out other content than a view (like dd, dump, echo) will result in the
        // header not being added because of content already sent.
        $response->header($headerName, $this->traceTag->tag());
        return $response;
   }
}
