<?php declare(strict_types=1);

namespace Bonsi\TraceTag\Generators;

use Ramsey\Uuid\Uuid;

class Uuid4 implements Generator
{
    public function generate() : string
    {
        // Generate a version 4 (random) UUID object
        return Uuid::uuid4()->toString();
    }
}