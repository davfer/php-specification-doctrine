<?php

namespace PhpSpecification\Doctrine\Test\Resources\Specs;

use PhpSpecification\Specification\AttrSpecification;
use PhpSpecification\Specification\Specification;

class UserByNameSpecification implements Specification
{
    public function __construct(
        public readonly string $name,
    )
    {
    }

    public function isSatisfiedBy(object $object): bool
    {
        return (new AttrSpecification('name', $this->name))->isSatisfiedBy($object);
    }
}