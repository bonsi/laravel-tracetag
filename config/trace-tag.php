<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel TraceTag
    |--------------------------------------------------------------------------
    */
    //    'enabled' => true,

    /*
    |
    | The generator will default to Bonsi\TraceTag\Generators\RandomInt::class.
    |
    */
    'generator' => Bonsi\TraceTag\Generators\RandomInt::class,
//    'generator' => Bonsi\TraceTag\Generators\Uuid4::class,


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
        'headerName' => 'X-Trace-Tag',
        'inputName' => '_tracetag',
    ]
];
