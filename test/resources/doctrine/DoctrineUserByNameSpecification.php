<?php

namespace PhpSpecification\Doctrine\Test\Resources\Doctrine;

use PhpSpecification\Doctrine\Specification\DoctrineAttrSpecification;
use PhpSpecification\Doctrine\Test\Resources\Specs\UserByNameSpecification;

class DoctrineUserByNameSpecification extends DoctrineAttrSpecification
{
    public function __construct(
        public readonly string $name,
    )
    {
        parent::__construct('name', $this->name);
    }

    public static function getSpecification(): string
    {
        return UserByNameSpecification::class;
    }
}