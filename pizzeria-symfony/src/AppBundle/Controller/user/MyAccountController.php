<?php

namespace AppBundle\Controller\user;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\RegistrationType;
use AppBundle\Service\Protection;

class MyAccountController extends Controller{
    
    private $protection;
    
    public function __construct(){
        $this->protection = new Protection();
    }
      
    /**
     * @Route("user/my-account", name="user-my-account")
     */
    public function account(Request $request){
        $this->protection->userProtection($request);
        $session = $request->getSession();
        $userID = $session->get('userID');
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($userID);
        
       
        $form = $this->createForm(RegistrationType::class,$user); 
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('user-my-account');
        }
        
        return $this->render('user/my-account.html.twig',
            ['form' => $form->createView(),
                'user' => $user]);
    }

}