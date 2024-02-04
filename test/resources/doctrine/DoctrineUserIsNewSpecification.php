<?php

namespace PhpSpecification\Doctrine\Test\Resources\Doctrine;

use Doctrine\ORM\Query\Expr;
use PhpSpecification\Doctrine\Specification\DoctrineAttrSpecification;
use PhpSpecification\Doctrine\Test\Resources\Specs\UserIsNewSpecification;

class DoctrineUserIsNewSpecification extends DoctrineAttrSpecification
{
    public function __construct()
    {
        parent::__construct('id', 1, Expr\Comparison::GT);
    }

    public static function getSpecification(): string
    {
        return UserIsNewSpecification::class;
    }
}