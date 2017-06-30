<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel TraceTag
    |--------------------------------------------------------------------------
    |
    | Here are the valid tag generators to choose from.
    |
    | The generator will default to Bonsi\TraceTag\Generators\RandomInt::class.
    |
    */

    'generator' => Bonsi\TraceTag\Generators\RandomInt::class,
//    'generator' => Bonsi\TraceTag\Generators\Uuid4::class,

    'middleware' => [
        'enabled' => true,
        'headerName' => 'X-Trace-Tag',
        'inputName' => '_tracetag',
    ]
];
