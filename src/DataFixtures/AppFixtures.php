<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{

    private int $MAX_PRODUCTS = 25;
    private int $MAX_USERS = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        //Products
        for ($i = 0; $i < $this->MAX_PRODUCTS; $i++) {
            $product = new Product();
            $product->updateProduct(
                $faker->word(),
                $faker->sentence(),
                $faker->randomFloat(2, 0, 15)
            );
            $manager->persist($product);
        }

        //Users
        for ($i = 0; $i < $this->MAX_USERS; $i++) {
            $user = new User();
            $user->updateIdentifier($faker->email(), 'azerty');
            $user->updateIdentity($faker->firstName(), $faker->lastName());
            $user->updateAddress($faker->streetAddress(), $faker->city(), $faker->postcode());

            $manager->persist($user);
        }

        $manager->flush();
    }
}
