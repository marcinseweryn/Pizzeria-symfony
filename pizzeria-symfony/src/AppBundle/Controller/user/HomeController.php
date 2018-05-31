<?php

namespace AppBundle\Controller\user;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller{
    
    /**
     * @Route("user/home", name="user-home")
     */
    public function generateView(Request $request){
    
        return $this->render('user/home.html.twig');
    }
}