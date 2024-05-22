<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
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

        $user = new User();
        $user
            ->setUsername("bobbydu69")
            ->setPassword(
                $this->hasher->hashPassword(
                    $user,
                    "bobby"
                )
            );

        $manager->persist($user);

        $manager->flush();
    }
}
