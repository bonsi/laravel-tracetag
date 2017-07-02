<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel TraceTag
    |--------------------------------------------------------------------------
    */

    /*
    | The configured generator for new tags.
    */
    'generator' => Bonsi\TraceTag\Generators\RandomIntGenerator::class,
//    'generator' => Bonsi\TraceTag\Generators\Uuid4Generator::class,

    /*
    | The middleware used for getting & setting TraceTags.
    */
    'middleware' => [
        'enabled' => false,
        /*
        |
        | If headerName is set on the request, set the TraceTag to this value.
        | The same value will be added to the response as a header as well.
        | inputName can also be used to set the TraceTag value but the
        | value from the header will always take precedence.
        |
        */
        'header-name' => 'X-Trace-Tag',
        'input-name' => '_tracetag',
    ]
];
