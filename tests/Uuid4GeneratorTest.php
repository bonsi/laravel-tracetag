<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Bonsi\TraceTag\Generators\Uuid4Generator;

class Uuid4GeneratorTest extends TestCase
{

    /** @test */
    function it_has_a_valid_uuid_version_4_string_format()
    {
    	$generator = new Uuid4Generator;

        $traceTag = $generator->generate();

        $this->assertRegExp(
            '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i',
            $traceTag,
            'Invalid UUID version 4 string format.'
        );
    }

    /** @test */
    function uuid_4_trace_tags_must_be_unique()
    {
        $generator = new Uuid4Generator;

        $traceTags = array_map(function ($i) use ($generator) {
            return $generator->generate();
        }, range(1, 100));

        $this->assertCount(100, array_unique($traceTags));
    }

}