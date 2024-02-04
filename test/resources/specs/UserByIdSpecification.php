<?php

namespace PhpSpecification\Doctrine\Test\Resources\Specs;

use PhpSpecification\Specification\Specification;

class UserByIdSpecification implements Specification
{
    public function __construct(
        public readonly int $id,
    )
    {
    }

    public function isSatisfiedBy(object $object): bool
    {
        return $object->id === $this->id;
    }
}