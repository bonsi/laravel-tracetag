<?php
namespace Bonsi\TraceTag\Generators;

class RandomInt implements Generator
{
    public function generate()
    {
        return random_int(0, PHP_INT_MAX);
    }
}