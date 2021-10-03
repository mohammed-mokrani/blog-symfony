<?php

namespace App\Controller;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use App\Form\RegistrationType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SecurityController extends AbstractController
{
     /**
     * @Route("/inscription", name= "security_registration")
     */

    public function registration(Request $request,EntityManagerInterface  $manager,
    UserPasswordHasherInterface $passwordHasher){

        $user = new User();
        $form = $this->createForm(RegistrationType::class,$user);
     
        $form->handleRequest($request);  //analyser la requete

        if($form->isSubmitted() && $form->isValid()){

            //$this->passwordHasher = $passwordHasher;

           $hash = $passwordHasher->hashPassword($user,$user->getPassword());

            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('security_login');
        }

   return $this->render('security/registration.html.twig',[
            'form'=> $form->createView()
        ]);
    } 
    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(){
        return $this->render('security/login.html.twig');
    }

    /**
     * @route("/deconnexion", name="security_logout")
     */
    public function logout(){}

}
