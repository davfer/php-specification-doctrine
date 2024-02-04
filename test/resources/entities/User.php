<?php

namespace PhpSpecification\Doctrine\Test\Resources\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class User
{
    #[Id, Column(type: "integer"), GeneratedValue(strategy: "IDENTITY")]
    public int $id;

    #[Column(type: "string")]
    public string $name;

    #[Column(type: "string")]
    public string $email;


}