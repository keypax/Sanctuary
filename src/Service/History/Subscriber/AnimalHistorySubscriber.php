<?php

namespace App\Service\History\Subscriber;

use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: Animal::class)]
#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: Animal::class)]
#[AsEntityListener(event: Events::preRemove, method: 'preRemove', entity: Animal::class)]
class AnimalHistorySubscriber
{
    private int $count = 0;

    function __construct(
        private LoggerInterface $logger
    ) {

    }

    public function prePersist(Animal $animal, PrePersistEventArgs $args): void
    {
        $changes = $this->getChanges($animal, $args);
    }

    public function preUpdate(Animal $animal, PreUpdateEventArgs $args): void
    {
        $changes = $this->getChanges($animal, $args);
    }

    public function preRemove(Animal $animal, PreRemoveEventArgs $args): void
    {
        $changes = $this->getChanges($animal, $args);
    }

    private function getChanges(Animal $animal, LifecycleEventArgs $args): ?array {
        dd($args->getObjectManager()->getUnitOfWork()->getEntityChangeSet($animal));
    }
}