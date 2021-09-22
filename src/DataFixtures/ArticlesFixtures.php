<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use Faker\Factory;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i = 1; $i <= 10; $i++) {

            $article = new Article();
            $article->setTitle("$faker->sentence")
                    ->setContent("<p>$faker->text</p>")
                    ->setImage($faker->imageUrl(350, 150, 'animals', true))
                    ->setCreatedAt(new \DateTimeImmutable($faker->date('Y-m-d H:i:s')));
            
            $manager->persist($article);
        }

        $manager->flush();
    }
}
