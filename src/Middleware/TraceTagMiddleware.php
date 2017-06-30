<?php declare(strict_types=1);

namespace Bonsi\TraceTag\Middleware;

use Closure;
use Bonsi\TraceTag\TraceTag;

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
        $headerName = config('tracetag.middleware.headerName', 'X-Trace-Tag');
        $inputName = config('tracetag.middleware.inputName', '_tracetag');

        if($request->has($inputName))
        {
            $this->traceTag->setTag($request->get($inputName));
        }
        if($request->hasHeader($headerName))
        {
            $this->traceTag->setTag($request->header($headerName));
        }

        $tag = $this->traceTag->tag();
//        $request->merge(['X-Trace-Tag' => $tag]);

        $response = $next($request);

        // Do note that echo'ing out other content than a view (like dd, dump, echo) will result in the
        // header not being added because of content already sent.
        $response->header($headerName, $tag);
        return $response;
   }
}
