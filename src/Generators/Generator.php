<?php declare(strict_types=1);

namespace Bonsi\TraceTag\Generators;

interface Generator
{
    public function generate() : string;
}