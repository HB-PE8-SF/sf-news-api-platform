<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Author;
use App\Entity\Category;
use App\Entity\Reader;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private const CATEGORIES_NAMES = ["Voyage", "Sport", "Actualité", "Cuisine"];
    private const ARTICLES_NB = 50;

    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // --- CATÉGORIES ---
        $categories = [];

        foreach (self::CATEGORIES_NAMES as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);

            $categories[] = $category;
            $manager->persist($category);
        }

        // --- AUTEUR ---
        $author = new Author();
        $author
            ->setUsername("bobbydu69")
            ->setPassword(
                $this->hasher->hashPassword(
                    $author,
                    "bobby"
                )
            );

        $manager->persist($author);

        // --- LECTEUR ---
        $reader = new Reader();
        $reader
            ->setUsername("Jean-lit")
            ->setFavoriteCategory($faker->randomElement($categories))
            ->setPassword($this->hasher->hashPassword($reader, "jean"));

        $manager->persist($reader);

        // --- ARTICLES ---
        for ($i = 0; $i < self::ARTICLES_NB; $i++) {
            $article = new Article();
            $article
                ->setTitle($faker->realText(50))
                ->setContent($faker->realTextBetween(200, 350))
                // TODO: EventSubscriber
                ->setCreatedAt(new \DateTimeImmutable())
                ->setVisible($faker->boolean(70))
                ->setCategory($faker->randomElement($categories))
                ->setAuthor($author);

            $manager->persist($article);
        }

        $manager->flush();
    }
}
