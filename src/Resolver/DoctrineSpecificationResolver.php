<?php

namespace PhpSpecification\Doctrine\Resolver;

use Doctrine\ORM\EntityManager;
use Exception;
use PhpSpecification\Doctrine\Specification\DoctrineSpecification;
use PhpSpecification\Specification\Specification;
use ReflectionClass;

class DoctrineSpecificationResolver
{
    /**
     * @param array<class-string<DoctrineSpecification>> $doctrineSpecifications
     */
    public function __construct(
        private readonly EntityManager $entityManager,
        private readonly array         $doctrineSpecifications,
    )
    {
    }

    /**
     * @template T
     * @param class-string<T> $class
     * @return array<T>
     */
    public function resolve(Specification $specification, string $class): array
    {
        $doctrineSpecification = $this->findDoctrineSpecificationClass($specification);

        return $this->entityManager
            ->getRepository($class)
            ->createQueryBuilder($class[0])
            ->where($doctrineSpecification->getExpression($class[0]))
            ->setParameters($doctrineSpecification->getParameters())
            ->getQuery()
            ->getResult();
    }

    private function findDoctrineSpecificationClass(Specification $specification): DoctrineSpecification
    {
        return $this->createDoctrineSpecificationInstance($specification);
    }

    private function createDoctrineSpecificationInstance(Specification $specification): DoctrineSpecification
    {
        $reflectedDoctrineSpecification = new ReflectionClass($this->getDoctrineSpecificationFqcn($specification));
        $specificationParameters = $this->getSpecificationParameters($specification);

        return call_user_func_array(
            [$reflectedDoctrineSpecification, 'newInstance'],
            $specificationParameters,
        );
    }

    private function getDoctrineSpecificationFqcn(Specification $specification): string
    {
        foreach ($this->doctrineSpecifications as $fqcn) {
            if (call_user_func($fqcn . '::getSpecification') === $specification::class) {
                return $fqcn;
            }
        }

        throw new Exception(
            sprintf('Doctrine specification class for %s does not exist', $specification::class)
        );
    }

    private function getSpecificationParameters(Specification $specification): array
    {
        $reflectedSpecification = new ReflectionClass($specification);
        $constructorParameters = $reflectedSpecification->getConstructor()->getParameters();

        $classProps = $reflectedSpecification->getProperties();

        $params = [];
        foreach ($constructorParameters as $parameter) {
            $foundProp = null;
            foreach ($classProps as $prop) {
                if ($prop->getName() === $parameter->getName()) {
                    $foundProp = $prop;
                    break;
                }
            }

            $params[$parameter->getName()] = $foundProp?->getValue($specification);
        }

        return $params;
    }
}