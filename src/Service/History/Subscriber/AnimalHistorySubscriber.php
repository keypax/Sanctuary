<?php

declare(strict_types=1);

namespace App\Service\History\Subscriber;

use App\Entity\Animal;
use App\Entity\AnimalHistory;
use App\Repository\AnimalHistoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: Animal::class)]
#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: Animal::class)]
#[AsEntityListener(event: Events::preRemove, method: 'preRemove', entity: Animal::class)]
class AnimalHistorySubscriber
{
    function __construct(
        private TranslatorInterface $translator
    ) {

    }

    public function prePersist(Animal $animal, PrePersistEventArgs $args): void
    {
        $this->saveChanges($animal, $args);
    }

    public function preUpdate(Animal $animal, PreUpdateEventArgs $args): void
    {
        $this->saveChanges($animal, $args);
    }

    public function preRemove(Animal $animal, PreRemoveEventArgs $args): void
    {
        $this->saveChanges($animal, $args);
    }

    private function saveChanges(Animal $animal, LifecycleEventArgs $args): void {
        $changes = $args->getObjectManager()->getUnitOfWork()->getEntityChangeSet($animal);
        foreach ($changes as $name => $value) {
            $translatedName = $this->translator->trans($name);

            $animalHistory = new AnimalHistory();
            $animalHistory->setAnimal($animal);
            $animalHistory->setBefore(sprintf('%s: %s', $translatedName, $value[0]));
            $animalHistory->setAfter(sprintf('%s: %s', $translatedName, $value[1]));

            $animal->addAnimalHistory($animalHistory);
        }
    }
}