<?php declare(strict_types=1);

namespace Bonsi\TraceTag\Generators;

use Ramsey\Uuid\Uuid;

/**
 * Class Uuid4Generator
 *
 * @package Bonsi\TraceTag\Generators
 */
class Uuid4Generator implements Generator
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