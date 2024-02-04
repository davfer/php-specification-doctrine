<?php

namespace PhpSpecification\Doctrine\Specification;

use Doctrine\ORM\Query\Expr;
use PhpSpecification\Specification\AttrSpecification;
use Stringable;

class DoctrineAttrSpecification implements DoctrineSpecification
{
    private string $id;

    public function __construct(
        private readonly string $attr,
        private readonly mixed  $val,
        private readonly string $comparison = Expr\Comparison::EQ
    )
    {
        $this->id = crc32(spl_object_hash($this));
    }

    public static function getSpecification(): string
    {
        return AttrSpecification::class;
    }

    public function getExpression(string $alias): Stringable
    {
        return new Expr\Comparison(
            sprintf('%s.%s', $alias, $this->attr),
            $this->comparison,
            sprintf(':%s_%s', $this->attr, $this->id)
        );
    }

    public function getParameters(): array
    {
        return [sprintf('%s_%s', $this->attr, $this->id) => $this->val];
    }
}