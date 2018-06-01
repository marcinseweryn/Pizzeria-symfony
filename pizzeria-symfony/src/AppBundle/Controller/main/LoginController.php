<?php

namespace AppBundle\Controller\main;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\LoginType;

class LoginController extends Controller{
    

    /**
     * @Route("/login", name="login")
     */
    public function generateView(Request $request){  
        $user = new User();
        
        $form = $this->createForm(LoginType::class,$user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {  
            
            $user = $form->getData();
            $repository = $this->getDoctrine()->getRepository(User::class);
            $user = $repository->findOneBy(['email' => $user->getEmail(), 'password' => $user->getPassword()]);
            $role=NULL;
            if($user != NULL){
                $role = $user->getRole();
                $session = $request->getSession();
                $session->set('userID', $user->getId());
                $session->set('ROLE', $user->getRole());
            }
            
            if($role === "ROLE_USER"){
               
                return $this->redirectToRoute('user-home');
            }else if($role === "ROLE_ADMIN"){
                return $this->redirectToRoute('admin-home');
            }else{
                return $this->redirectToRoute('login');
            }
        }
        
        return $this->render('main/login.html.twig',
            ['form' => $form->createView()]);
    }
    
    public function logoff(){
        session_destroy();
        session_start();
        redirectTo("home");
    }
}