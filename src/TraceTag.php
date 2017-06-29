<?php
namespace Bonsi\TraceTag;

use Bonsi\TraceTag\Generators\Generator;

class TraceTag
{
    protected $tag = null;
    protected $generator = null;

    /**
     * TraceTag constructor.
     *
     * @param \App\TraceTag\Generators\Generator $generator
     */
    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Generate a new tag if none generated yet, and return it.
     *
     * @return string
     */
    public function tag() : string
    {
        if(! $this->tag) {
            $this->tag = $this->generateTag();
        }
        return $this->tag;
    }

    /**
     * Generate a new tag using the provided generator.
     *
     * @return string
     */
    private function generateTag() : string
    {
        return $this->generator->generate();
    }
}