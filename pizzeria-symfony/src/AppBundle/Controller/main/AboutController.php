<?php

namespace AppBundle\Controller\main;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AboutController extends Controller{
    
    /**
     * @Route("about", name="about")
     */
    public function generateView(Request $request){
        
        return $this->render('main/about.html.twig');
    }
}