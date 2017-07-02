<?php declare(strict_types=1);

namespace Bonsi\TraceTag\Generators;

use Ramsey\Uuid\Uuid;

/**
 * Class Uuid4
 *
 * @package Bonsi\TraceTag\Generators
 */
class Uuid4 implements Generator
{

    /**
     * Generate a version 4 (random) UUID object.
     *
     * @return string
     */
    public function generate() : string
    {
        return Uuid::uuid4()->toString();
    }
}