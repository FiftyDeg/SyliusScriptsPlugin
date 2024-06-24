<?php

declare(strict_types=1);

namespace FiftyDeg\SyliusScriptsPlugin\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping;
use FiftyDeg\SyliusScriptsPlugin\Entity\Script;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class ScriptRepository extends EntityRepository implements ScriptRepositoryInterface
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        /** @var class-string $className */
        $className = Script::class;

        $classMetadata = new Mapping\ClassMetadata($className);
        parent::__construct($entityManager, $classMetadata);
    }
}
