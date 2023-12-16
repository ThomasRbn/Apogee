<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    private int $MAX_PRODUCTS = 25;

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < $this->MAX_PRODUCTS; $i++) {
            $product = new \App\Entity\Product();
            $product->updateProduct(
                $faker->word(),
                $faker->sentence(),
                $faker->randomFloat(2, 0, 15)
            );
            $manager->persist($product);
        }

        $manager->flush();
    }
}
