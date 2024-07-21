<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Entity\Breed;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $types = ['Chien', 'Chat', 'Poule'];
        $dogBreeds = ['Berger allemand', 'Labrador', 'Bulldog', 'Beagle'];
        $catBreeds = ['Siamois', 'Persan', 'Sphynx'];
        $chickenBreeds = ['Plymouth Rock', 'Orpington', 'Brahma'];

        // Création types
        foreach ($types as $typeName) {
            $type = new Type();
            $type->setName($typeName);
            $manager->persist($type);
            $manager->flush();
        }

        // Création chiens
        $type = $manager->getRepository(Type::class)->findOneBy(['name' => 'Chien']);
        $count = 1;
        foreach ($dogBreeds as $breedName) {
            $breed = new Breed();
            $breed->setName($breedName);
            $breed->setType($type);
            $manager->persist($breed);

            $animal = new Animal();
            $animal->setType($type);
            $animal->setBreed($breed);
            $animal->setName('Chien ' . $count);
            $animal->setAge(random_int(1, 15));
            $animal->setDescription('Description du chien ' . $count);
            $animal->setPrice(random_int(100, 1000));
            $animal->setStatus(random_int(0, 1));
            $manager->persist($animal);

            $count++;
        }

        // Création chats
        $type = $manager->getRepository(Type::class)->findOneBy(['name' => 'Chat']);
        $count = 1;
        foreach ($catBreeds as $breedName) {
            $breed = new Breed();
            $breed->setName($breedName);
            $breed->setType($type);
            $manager->persist($breed);

            $animal = new Animal();
            $animal->setType($type);
            $animal->setBreed($breed);
            $animal->setName('Chat ' . $count);
            $animal->setAge(random_int(1, 15));
            $animal->setDescription('Description du chat ' . $count);
            $animal->setPrice(random_int(100, 1000));
            $animal->setStatus(random_int(0, 1));
            $manager->persist($animal);

            $count++;
        }

        // Création poules
        $type = $manager->getRepository(Type::class)->findOneBy(['name' => 'Poule']);
        $count = 1;
        foreach ($chickenBreeds as $breedName) {
            $breed = new Breed();
            $breed->setName($breedName);
            $breed->setType($type);
            $manager->persist($breed);

            $animal = new Animal();
            $animal->setType($type);
            $animal->setBreed($breed);
            $animal->setName('Poule ' . $count);
            $animal->setAge(random_int(1, 15));
            $animal->setDescription('Description de la poule ' . $count);
            $animal->setPrice(random_int(100, 1000));
            $animal->setStatus(random_int(0, 1));
            $manager->persist($animal);

            $count++;
        }

        $manager->flush();
    }
}
