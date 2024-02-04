<?php

namespace PhpSpecification\Doctrine\Test\Resources\Doctrine;

use PhpSpecification\Doctrine\Specification\DoctrineAttrSpecification;
use PhpSpecification\Doctrine\Test\Resources\Specs\UserByIdSpecification;

class DoctrineUserByIdSpecification extends DoctrineAttrSpecification
{
    public function __construct(
        public readonly int $id,
    )
    {
        parent::__construct('id', $this->id);
    }

    public static function getSpecification(): string
    {
        return UserByIdSpecification::class;
    }
}