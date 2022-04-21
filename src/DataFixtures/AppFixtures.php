<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $productNames = ['Pixel', 'Samsung', 'Nokia', 'Huawei'];
    private $Names = ['Orange', 'Bouygues', 'SFR', 'Free'];

    private $passwordHasher;


    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->faker=Factory::create("fr_FR");
        $this->passwordHasher=$passwordHasher;
    }

    /**
     * @throws \Exception
     */

    public function load(ObjectManager $manager): void
    {
// === Products ===

        for ($i = 0; $i <= 10; $i++) {
            $product = new Product();

            $product->setName($this->productNames[random_int(0, 3)])
                    ->setPrice(random_int(200, 1000 ))
                    ->setBrand($this->productNames[random_int(0, 3)] )
                    ->setDescription('lorem ipsum dolor sit amet, consectetur adip');

            $manager->persist($product);

// === Clients ===
            $client = new Client();

            $client->setName($this->Names[random_int(0, 3)] );

            $manager->persist($client);
        }

// === Users ===

        for ($i=0; $i <= 20; $i++) {
            $user = new User();


            $user->setUsername($this->faker->userName())
                 ->setEmail(strtolower($user->getUsername()) . "@gmail.com")
                 ->setPassword($this->passwordHasher->hashPassword($user,$user->getUsername()))
                 ->setClient($client);
                $this->addReference("user". $i, $user);


            $manager->persist($user);
        }


            $userAdmin = new User();
            $rolesAdmin[]=User::ROLE_ADMIN;

            $userAdmin->setUsername($this->faker->userName())
                      ->setEmail(strtolower($userAdmin->getUsername()) . "@gmail.com")
                      ->setPassword($this->passwordHasher->hashPassword($userAdmin,$userAdmin->getUsername()))
                      ->setRoles($rolesAdmin)
                      ->setClient($client);


            $manager->persist($userAdmin);

        $manager->flush();
    }
}