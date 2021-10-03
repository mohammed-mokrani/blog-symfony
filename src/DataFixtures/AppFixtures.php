<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use SebastianBergmann\Diff\Diff;
use Faker;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    
        // $product = new Product();
        // $manager->persist($product);

        $faker = Faker\Factory::create('fr_FR');

        //créer 3 categories fakées
        for($i = 1; $i<=3; $i++) {
            $category = new Category();
            $category->setTitle($faker->sentence())
                     ->setDescription($faker->paragraph());
            $manager->persist($category);

            //créer entre 4 et 6 arciles

            for($j = 1; $j <= mt_rand(4, 6); $j++){
                $article = new Article();
                //$content = '<p>' . join( $faker->paragraphs(5), '</p><p>') .'</p>';

                $article->setTitle($faker->sentence())
                        ->setContent($faker->paragraphs(5,true))
                        ->setImage($faker->imageUrl())
                        ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                        ->setCategory($category);
                    
                $manager->persist($article); 
                //on donne des commentaires à chaque article
                for($k=1;$k<= mt_rand(4, 10);$k++ ){
                    $comment = new Comment();
                    $days = (new \DateTime())->Diff($article->getCreatedAt());
                    //$content = '<p>' . join($faker->paragraphs(2),'</p><p>' ) .'</p>';

                    $comment->setAuthor($faker->name)
                            ->setContent($faker->paragraphs(2,true))
                            ->setCreatedAt($faker->dateTimeBetween('-3 months'))
                            ->setArticle($article);
                    $manager->persist($comment);

                }   
        }

        }
        $manager->flush();
    }
}
