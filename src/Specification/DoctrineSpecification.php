<?php

namespace PhpSpecification\Doctrine\Specification;

use PhpSpecification\Specification\Specification;

/**
 * @template TSpecification
 */
interface DoctrineSpecification
{
    /** @return class-string<Specification> */
    public static function getSpecification(): string;

    public function getExpression(string $alias): \Stringable;

    /** @return array<string, mixed> */
    public function getParameters(): array;
}