<?php declare(strict_types=1);

namespace Bonsi\TraceTag\Integrations;

use Bonsi\TraceTag\TraceTag;

/**
 * Class MonologProcessor
 *
 * @package Bonsi\TraceTag\Integrations
 */
class MonologProcessor
{

    /**
     * Modify the monolog log record.
     *
     * @param array $record
     * @return array
     */
    public function __invoke(array $record) : array
    {
        $record['extra']['TraceTag'] = $this->getTraceTag();
        return $record;
    }

    /**
     * @return string
     */
    public function getTraceTag()
    {
        return app()->make(TraceTag::class)->tag();
    }
}