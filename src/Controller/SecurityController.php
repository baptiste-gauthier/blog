<?php

namespace App\Controller;

use App\Form\RegistrationType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class SecurityController extends AbstractController
{

    /**
     * @Route("/inscription" , name="security_registration")
     */
    public function registration(Request $request ,EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher) {

        $user = new User(); 

        $form = $this->createForm(RegistrationType::class , $user); 

        dump($passwordHasher); 

        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid())
        { 
        //    $hash = $passwordHasher->hashPassword($user , $user->getPassword()) ; 

        //    $user->setPassword($hash); 
            $user->setPassword($passwordHasher->hashPassword(
                            $user,
                            $user->getPassword()
            ));

           $manager->persist($user);
           $manager->flush(); 
        }

        return $this->render('security/registration.html.twig' , [
            'form' => $form->createView()
        ]); 
    }
}
