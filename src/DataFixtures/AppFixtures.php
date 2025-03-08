<?php

namespace App\DataFixtures;

use App\Entity\AnimalBreed;
use App\Entity\AnimalSpecies;
use App\Entity\Enclosure;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->addSpeciesAndBreeds($manager);
        $this->addEnclosures($manager);

        $manager->flush();
    }

    private function addSpeciesAndBreeds(ObjectManager $manager): void {
        $species = [
            'Other' => [],
            'Cat' => [
                'Maine Coon',
                'Ragdoll',
                'British Shorthair',
                'Persian',
                'Siamese',
                'American Shorthair',
                'Bengal',
                'Sphynx',
                'Abyssinian',
                'Russian Blue',
            ],
            'Dog' => [
                'French Bulldog',
                'Labrador Retriever',
                'Golden Retriever',
                'German Shepherd',
                'Poodle',
                'Bulldog',
                'Rottweiler',
                'Beagle',
                'Dachshund',
                'German Shorthaired Pointer',
                'Yorkshire Terrier',
                'Boxer',
                'Doberman Pinscher',
                'Siberian Husky',
                'Australian Shepherd',
                'Shih Tzu',
                'Miniature Schnauzer',
                'Cavalier King Charles Spaniel',
                'Bernese Mountain Dog',
                'Great Dane',
                'Pomeranian',
                'Pembroke Welsh Corgi',
                'Boston Terrier',
                'Havanese',
                'Maltese',
                'Shetland Sheepdog',
                'Brittany',
                'English Springer Spaniel',
                'Vizsla',
                'Weimaraner',

            ],
            'Rabbit' => [],
            'Guinea Pig' => [],
            'Rat' => [],
            'Mouse => []',
            'Rodent (other)' => [],
            'Parrot' => [],
            'Pigeon' => [],
            'Bird (other)' => [],
            'Amphibian' => [],
            'Fish' => [],
            'Pig' => [],
            'Goat' => [],
            'Sheep' => [],
            'Chicken' => [],
            'Turtle' => [],
            'Tortoise' => [],
            'Snake' => [],
            'Lizard' => [],
        ];

        foreach ($species as $speciesName => $breeds) {
            $species = new AnimalSpecies();
            $species->setSpeciesName($speciesName);

            foreach ($breeds as $breedName) {
                $breed = new AnimalBreed();
                $breed->setBreedName($breedName);
                $species->addAnimalBreed($breed);
            }

            $manager->persist($species);
        }
    }

    private function addEnclosures(ObjectManager $manager): void
    {
        $enclosures = [
            'Box 1 (Dogs)',
            'Box 2 (Dogs)',
            'Box 3 (Dogs)',
            'Box 4 (Dogs)',
            'Box 5 (Dogs)',
            'Box 6 (Cats)',
            'Box 7 (Cats)',
            'Box 8 (Cats)',
            'Box 9 (Pigs)',
            'Box 10 (Rodents)',
        ];

        foreach ($enclosures as $enclosureName) {
            $enclosure = new Enclosure();
            $enclosure->setEnclosureName($enclosureName);
            $manager->persist($enclosure);
        }
    }
}
