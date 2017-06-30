<?php declare(strict_types=1);

namespace Bonsi\TraceTag\Generators;

class RandomInt implements Generator
{
    public function generate() : string
    {
        return (string)random_int(0, PHP_INT_MAX);
    }
}