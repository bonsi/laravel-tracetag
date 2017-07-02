<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Bonsi\TraceTag\Generators\RandomIntGenerator;

class RandomIntTraceTagGeneratorTest extends TestCase
{

    /** @test */
    function it_contains_only_positive_numbers()
    {
    	$generator = new RandomIntGenerator;

        $traceTag = $generator->generate();

        $this->assertRegExp('/^[0-9]+$/', $traceTag);
    }

    /** @test */
    function random_int_trace_tags_must_be_unique()
    {
        $generator = new RandomIntGenerator;

        $traceTags = array_map(function ($i) use ($generator) {
            return $generator->generate();
        }, range(1, 100));

        $this->assertCount(100, array_unique($traceTags));
    }

}