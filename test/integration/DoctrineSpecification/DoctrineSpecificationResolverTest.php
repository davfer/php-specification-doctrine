<?php

namespace PhpSpecification\Doctrine\Test\Integration\DoctrineSpecification;

use PhpSpecification\Doctrine\Resolver\DoctrineSpecificationResolver;
use PhpSpecification\Doctrine\Test\Resources\Doctrine\DoctrineTestCase;
use PhpSpecification\Doctrine\Test\Resources\Doctrine\DoctrineUserByIdAndEmailSpecification;
use PhpSpecification\Doctrine\Test\Resources\Doctrine\DoctrineUserByIdSpecification;
use PhpSpecification\Doctrine\Test\Resources\Doctrine\DoctrineUserByNameSpecification;
use PhpSpecification\Doctrine\Test\Resources\Doctrine\DoctrineUserIsNewSpecification;
use PhpSpecification\Doctrine\Test\Resources\Entities\User;
use PhpSpecification\Doctrine\Test\Resources\Specs\UserByIdAndNameSpecification;
use PhpSpecification\Doctrine\Test\Resources\Specs\UserByIdSpecification;
use PhpSpecification\Doctrine\Test\Resources\Specs\UserIsNewSpecification;

class DoctrineSpecificationResolverTest extends DoctrineTestCase
{

    public function testResolveWithAttr()
    {
        $em = $this->createEntityManager();
        $this->createFixtures();

        $sut = new DoctrineSpecificationResolver(
            $em,
            [
                DoctrineUserByIdSpecification::class,
            ]
        );

        $actual = $sut->resolve(new UserByIdSpecification(1), User::class);
        $expected = [$this->getEntity(User::class, 1)];

        self::assertEquals($expected, $actual);
    }

    public function testResolveWithComposite()
    {
        $em = $this->createEntityManager();
        $this->createFixtures();

        $sut = new DoctrineSpecificationResolver(
            $em,
            [
                DoctrineUserByIdSpecification::class,
                DoctrineUserByNameSpecification::class,
                DoctrineUserByIdAndEmailSpecification::class,
            ]
        );

        $actual = $sut->resolve(new UserByIdAndNameSpecification(2, 'Jane Doe'), User::class);
        $expected = [
            $this->getEntity(User::class, 2),
        ];

        self::assertEquals($expected, $actual);
    }

    public function testResolveWithCollection()
    {
        $em = $this->createEntityManager();
        $this->createFixtures();

        $sut = new DoctrineSpecificationResolver(
            $em,
            [
                DoctrineUserIsNewSpecification::class,
            ]
        );

        $actual = $sut->resolve(new UserIsNewSpecification(), User::class);
        $expected = [
            $this->getEntity(User::class, 2),
            $this->getEntity(User::class, 3),
        ];

        self::assertEquals($expected, $actual);
    }
}
