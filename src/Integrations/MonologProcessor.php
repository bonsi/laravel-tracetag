<?php declare(strict_types=1);

namespace Bonsi\TraceTag\Integrations;

use Bonsi\TraceTag\TraceTag;

class MonologProcessor
{

    public function __invoke(array $record) : array
    {
//        $record['extra']['uid'] = $this->uid;
        $record['extra']['TraceTag'] = $this->getTraceTag();
//        $record['message'] = "[{$this->getTraceTag()}] ".$record['message'];
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