<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for($i = 1; $i < 10; $i++){
            $article = new Article();
            $article->setTitle("Titre de l'article n°$i")
                    ->setContent("<p>Contenu de l'article n°$i")
                    ->setImage("https://via.placeholder.com/300")
                    ->setCreatedAt(new \DateTimeImmutable());
                
            $manager->persist($article);
        }
        $manager->flush();
    }
}
