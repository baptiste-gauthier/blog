<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use DateTimeImmutable;
use Faker\Factory;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        // Création de 3 fausses catégories

        for($i = 1 ; $i < 4 ; $i++)
        {
            $category = new Category();
            $category->setTitle($faker->sentence())
                    ->setDescription($faker->paragraph());

            $manager->persist($category); 

            // Création des articles
                    
            for($j = 1; $j <= mt_rand(4,6); $j++) {
    
                $article = new Article();

                $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';

                $date = new \DateTimeImmutable($faker->date('Y-m-d H:i:s'));
                
                $article->setTitle($faker->sentence())
                        ->setContent($content)
                        ->setImage($faker->imageUrl())
                        ->setCreatedAt($date)
                        ->setCategory($category);
                
                $manager->persist($article);
            }

            // Creation des commentaires 

            for($k = 1 ; $k <= mt_rand(4,10) ; $k++) {
                $comment = new Comment(); 

                $content = '<p>' . join('</p><p>', $faker->paragraphs(2)) . '</p>';

                $days = (new \DateTimeImmutable())->diff($article->getCreatedAt())->days;

                $comment->setAuthor($faker->name())
                        ->setContent($content)
                        ->setCreatedAt($faker->dateTimeBetween('-' . $days . ' days'))
                        ->setArticle($article) ; 

                $manager->persist($comment); 

            }
        }


        $manager->flush();
    }
}
