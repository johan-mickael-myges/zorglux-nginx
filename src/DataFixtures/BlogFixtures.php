<?php

namespace App\DataFixtures;

use App\Entity\Blog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Create blog posts
        for ($i = 0; $i < 10; $i++) {
            $blog = new Blog();
            $blog->setTitle($faker->sentence);
            $blog->setDescription($faker->paragraph);
            $blog->setThumbnail($faker->imageUrl());
            $blog->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year')));
            $blog->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->dateTime('+ 1 month')));

            $manager->persist($blog);
        }

        $manager->flush();
    }
}
