<?php

namespace AppBundle\Controller\main;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use AppBundle\Form\Type\RegistrationType;

class RegistrationController extends Controller{
      
    /**
     * @Route("/registration", name="registration")
     */
    public function register(Request $request){
        
        $user = new User();
        $user->setRole("ROLE_USER");
       
        $form = $this->createForm(RegistrationType::class,$user); 
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }
        
        return $this->render('main/registration.html.twig',
            ['form' => $form->createView()]);
    }

}