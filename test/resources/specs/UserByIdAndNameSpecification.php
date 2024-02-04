<?php

namespace PhpSpecification\Doctrine\Test\Resources\Specs;

use PhpSpecification\Specification\AndSpecification;
use PhpSpecification\Specification\Specification;

class UserByIdAndNameSpecification implements Specification
{
    public function __construct(
        public readonly int    $id,
        public readonly string $name,
    )
    {
    }

    public function isSatisfiedBy(object $object): bool
    {
        return (new AndSpecification(
            new UserByNameSpecification($this->id),
            new UserByIdSpecification($this->name)
        ))->isSatisfiedBy($object);
    }
}