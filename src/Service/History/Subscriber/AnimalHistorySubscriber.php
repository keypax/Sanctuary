<?php

declare(strict_types=1);

namespace App\Service\History\Subscriber;

use App\Entity\Animal;
use App\Entity\AnimalHistory;
use App\Service\Animal\Choice\ChoicesServiceInterface;
use App\Service\Animal\Choice\Exception\ChoicesProviderException;
use App\Service\History\HistoryTrackedInterface;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use PHPUnit\Exception;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use ReflectionException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: Animal::class)]
#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: Animal::class)]
#[AsEntityListener(event: Events::preRemove, method: 'preRemove', entity: Animal::class)]
readonly class AnimalHistorySubscriber
{
    public function __construct(
        private ChoicesServiceInterface $choicesService,
        private Security $security,
        private TranslatorInterface $translator,
        private LoggerInterface $logger
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
            $animalHistory->setUser($this->security->getUser());
            $animalHistory->setDatetime(new DateTimeImmutable());

            try {
                $beforeVal = $this->processValue($name, $value[0]);
                $animalHistory->setBefore(sprintf('%s: %s', $translatedName, $beforeVal));

                $afterVal = $this->processValue($name, $value[1]);
                $animalHistory->setAfter(sprintf('%s: %s', $translatedName, $afterVal));
            }
            catch (Exception $e) {
                //we don't want to crash the whole saving process. If you cannot save to history, that's not the end of the world
                $this->logger->error('Error while processing value for history: ' . $e->getMessage());
            }

            $animal->addAnimalHistory($animalHistory);
        }
    }


    /**
     * @throws ReflectionException
     * @throws ChoicesProviderException
     */
    private function processValue(string $name, mixed $value): string {
        if ($this->choicesService->isKeySupported($name)) {
            if ($value === null) {
                //value can be null in the form, so we leave it empty
                return '';
            }

            if ($value instanceof HistoryTrackedInterface) {
                return $this->translator->trans($value->getHistoryContext());
            }

            /** @noinspection PhpUnhandledExceptionInspection */
            $key = $this->choicesService->getProviderByKey($name)->getKeyByValue($value);

            return $this->translator->trans($key);
        }

        if ($value instanceof DateTime) {
            return $value->format('Y-m-d');
        }

        return (string) $value;
    }
}