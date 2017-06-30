<?php declare(strict_types=1);

namespace Bonsi\TraceTag;

use Bonsi\TraceTag\Generators\Generator;

class TraceTag
{
    protected $tag = null;
    protected $generator = null;

    /**
     * TraceTag constructor.
     *
     * @param \Bonsi\TraceTag\Generators\Generator $generator
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
        if(! $this->tag ) {
            $this->setTag($this->generateTag());
        }

        return $this->tag;
    }

    /**
     * Set the tag.
     *
     * @param $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
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