<?php

namespace PhpSpecification\Doctrine\Test\Resources\Specs;

use PhpSpecification\Specification\Specification;

class UserIsNewSpecification implements Specification
{
    public function __construct()
    {
    }

    public function isSatisfiedBy(object $object): bool
    {
        return $object->id > 1;
    }
}