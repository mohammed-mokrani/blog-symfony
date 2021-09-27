<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Article;
#use Doctrine\Persistence\ObjectManager;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManagerInterface;
#use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectManager;



class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog')]
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo) //grace aux inkections
    {
        //sinon   $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    
    /**
     * @Route("/", name="home")
     */
    public function home(){

        return $this->render('blog/home.html.twig');
        
    }



    /**
     * @Route("/blog/new", name="blog_create")
     */
    public function form(Request $resquest,EntityManagerInterface $manager): Response {
        $article = new Article();
        
        $form = $this->createFormBuilder($article)
                    ->add('title')
                    ->add('content')
                    ->add('image')
                    ->getForm();
        $form->handleRequest($resquest);
        if($form->isSubmitted() && $form->isValid()){
            $article->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('blog_show', ['id' => $article->getId()
        ]);
        }

        return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView()
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show($id){  //grace au param converteur
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $article = $repo->find($id);
        return $this->render('blog/show.html.twig',[
            'article' => $article
        ]);
    }
    
}
