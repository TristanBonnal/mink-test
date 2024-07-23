<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Entity\Breed;
use App\Entity\Picture;
use App\Entity\Type;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct (
        private readonly UserPasswordHasherInterface $passwordHasher
    ){}
    public function load(ObjectManager $manager): void
    {
        $types = ['Chien', 'Chat', 'Poule'];
        $dogBreeds = [
            'Berger allemand' => 'berger_allemand.jpg',
            'Labrador' => 'labrador.jpg',
            'Beagle' => 'beagle.jpg'
        ];
        $catBreeds = [
            'Siamois' => 'siamois.jpg',
            'Persan' => 'persan.jpg',
        ];
        $chickenBreeds = [
            'Plymouth Rock' => 'plymouth_rock.jpg',
            'Orpington' => 'orpington.jpg',
        ];

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
        foreach ($dogBreeds as $breedName => $pictureUrl) {
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

            $picture = new Picture();
            $picture->setUrl($pictureUrl);
            $picture->setAnimal($animal);
            $manager->persist($picture);

            $count++;
        }

        // Création chats
        $type = $manager->getRepository(Type::class)->findOneBy(['name' => 'Chat']);
        $count = 1;
        foreach ($catBreeds as $breedName => $pictureUrl) {
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

            $picture = new Picture();
            $picture->setUrl($pictureUrl);
            $picture->setAnimal($animal);
            $manager->persist($picture);

            $count++;
        }

        // Création poules
        $type = $manager->getRepository(Type::class)->findOneBy(['name' => 'Poule']);
        $count = 1;
        foreach ($chickenBreeds as $breedName => $pictureUrl) {
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

            $picture = new Picture();
            $picture->setUrl($pictureUrl);
            $picture->setAnimal($animal);
            $manager->persist($picture);

            $count++;
        }

        // Création utilisateur
        $user = new User();
        $user->setEmail('user@user.fr');;
        $user->setPassword($this->passwordHasher->hashPassword($user, 'user'));
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        // Création administrateur
        $admin = new User();
        $admin->setEmail('admin@admin.fr');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $manager->flush();
    }
}
