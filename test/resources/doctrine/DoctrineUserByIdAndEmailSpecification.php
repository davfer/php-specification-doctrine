<?php

namespace PhpSpecification\Doctrine\Test\Resources\Doctrine;

use PhpSpecification\Doctrine\Specification\DoctrineAndSpecification;
use PhpSpecification\Doctrine\Test\Resources\Specs\UserByIdAndNameSpecification;

class DoctrineUserByIdAndEmailSpecification extends DoctrineAndSpecification
{
    public function __construct(
        public readonly int    $id,
        public readonly string $name,
    )
    {
        parent::__construct(
            [
                new DoctrineUserByIdSpecification($this->id),
                new DoctrineUserByNameSpecification($this->name),
            ]
        );
    }

    public static function getSpecification(): string
    {
        return UserByIdAndNameSpecification::class;
    }
}