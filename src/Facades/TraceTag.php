<?php declare(strict_types=1);

namespace Bonsi\TraceTag\Facades;

use Illuminate\Support\Facades\Facade;

class TraceTag extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tracetag';
    }
}
