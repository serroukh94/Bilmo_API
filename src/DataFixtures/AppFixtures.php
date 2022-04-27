<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $productNames = ['Pixel', 'Samsung', 'Nokia', 'Huawei'];
    private $Names = ['Orange', 'Bouygues', 'SFR', 'Free'];

    private $passwordHarsher;


    public function __construct(UserPasswordHasherInterface $passwordHarsher)
    {
        $this->faker=Factory::create("fr_FR");
        $this->passwordHarsher=$passwordHarsher;
    }

    /**
     * @throws Exception
     */

    public function load(ObjectManager $manager): void
    {
// === Products ===

        for ($i = 0; $i <= 10; $i++) {
            $product = new Product();

            $product->setName($this->productNames[random_int(0, 3)])
                    ->setPrice(random_int(200, 1000 ))
                    ->setBrand($this->productNames[random_int(0, 3)] )
                    ->setDescription('lorem ipsum dolor sit amet, consecrate dip');

            $manager->persist($product);
        }
// === Clients ===
        for ($i = 0; $i <= 3; $i++) {
            $client = new Client();


            $client->setName($this->Names[random_int(0, 3)] )
                   ->setEmail(strtolower($client->getname()) . "@gmail.com")
                   ->setPassword($this->passwordHarsher->hashPassword($client, 'admin'));



            $manager->persist($client);
        }

// === Users ===

        for ($i=0; $i <= 20; $i++) {
            $user = new User();


            $user->setUsername($this->faker->userName())
                 ->setEmail($this->faker->email)
                 ->setPassword($this->passwordHarsher->hashPassword($user,$user->getUsername()))
                 ->setClient($client);



            $manager->persist($user);
        }


        $manager->flush();
    }
}