<?php

declare(strict_types=1);

namespace FiftyDeg\SyliusScriptsPlugin\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping;
use FiftyDeg\SyliusScriptsPlugin\Entity\ScriptTranslation;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class ScriptTranslationRepository extends EntityRepository implements ScriptTranslationRepositoryInterface
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        /** @var class-string $className */
        $className = ScriptTranslation::class;

        $classMetadata = new Mapping\ClassMetadata($className);
        parent::__construct($entityManager, $classMetadata);
    }
}
