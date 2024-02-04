<?php

namespace PhpSpecification\Doctrine\Specification;

use Doctrine\ORM\Query\Expr;
use PhpSpecification\Specification\OrSpecification;
use Stringable;

class DoctrineOrSpecification implements DoctrineSpecification
{
    /**
     * @param array<DoctrineSpecification> $expressions
     */
    public function __construct(private readonly array $expressions)
    {
    }

    public static function getSpecification(): string
    {
        return OrSpecification::class;
    }

    public function getExpression(string $alias): Stringable
    {
        return new Expr\Orx(array_map(fn(DoctrineSpecification $s) => $s->getExpression($alias), $this->expressions));
    }

    public function getParameters(): array
    {
        return array_reduce(
            $this->expressions,
            fn(array $carry, DoctrineSpecification $s) => array_merge($carry, $s->getParameters()),
            []
        );
    }
}