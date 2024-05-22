<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const CATEGORIES_NAMES = ["Voyage", "Sport", "Actualité", "Cuisine"];
    private const ARTICLES_NB = 50;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $categories = [];

        foreach (self::CATEGORIES_NAMES as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);

            $categories[] = $category;
            $manager->persist($category);
        }

        for ($i = 0; $i < self::ARTICLES_NB; $i++) {
            $article = new Article();
            $article
                ->setTitle($faker->realText(50))
                ->setContent($faker->realTextBetween(200, 350))
                // TODO: EventSubscriber
                ->setCreatedAt(new \DateTimeImmutable())
                ->setVisible($faker->boolean(70))
                ->setCategory($faker->randomElement($categories));

            $manager->persist($article);
        }

        $manager->flush();
    }
}
