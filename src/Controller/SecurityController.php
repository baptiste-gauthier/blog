<?php

namespace App\Controller;

use App\Form\RegistrationType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription" , name="security_registration")
     */
    public function registration(Request $request ,EntityManagerInterface $manager) {

        $user = new User(); 

        $form = $this->createForm(RegistrationType::class , $user); 

        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid())
        {
           $manager->persist($user);
        }

        return $this->render('security/registration.html.twig' , [
            'form' => $form->createView()
        ]); 
    }
}
