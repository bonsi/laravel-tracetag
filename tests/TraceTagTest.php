<?php declare(strict_types=1);

use Bonsi\TraceTag\TraceTag;
use PHPUnit\Framework\TestCase;
use Bonsi\TraceTag\Generators\RandomIntGenerator;

class TraceTagTest extends TestCase
{

    /** @test */
    function it_generates_a_new_trace_tag_if_none_set()
    {
        $generator = Mockery::mock(RandomIntGenerator::class);
        $generator->shouldReceive('generate')->andReturn('FAKE_RANDOM_INT');

    	$traceTag = new TraceTag($generator);

        $this->assertEquals('FAKE_RANDOM_INT', $traceTag->tag());
    }

    /** @test */
    function it_keeps_returning_the_same_trace_tag()
    {
        $traceTag = new TraceTag(new RandomIntGenerator);

        $traceTags = array_map(function ($i) use ($traceTag) {
            return $traceTag->tag();
        }, range(1, 100));

        $this->assertCount(1, array_unique($traceTags));
    }

    /** @test */
    function it_keeps_returning_the_same_trace_tag_after_it_has_been_set_from_the_outside()
    {
        $traceTag = new TraceTag(new RandomIntGenerator);

        $initialTag = $traceTag->tag();

        $newTag = '7777777';
        $traceTag->setTag($newTag);

        $this->assertNotEquals($initialTag, $traceTag->tag());
        $this->assertEquals($newTag, $traceTag->tag());
    }

    protected function tearDown()
    {
        parent::tearDown();

        if (class_exists('Mockery')) {
            Mockery::close();
        }
    }

}