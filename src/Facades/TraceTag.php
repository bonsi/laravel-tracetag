<?php declare(strict_types=1);

namespace Bonsi\TraceTag\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * TraceTag facade
 *
 * @package Bonsi\TraceTag\Facades
 */
class TraceTag extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tracetag';
    }
}
