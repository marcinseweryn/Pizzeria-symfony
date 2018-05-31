<?php

namespace AppBundle\Controller\admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller{
    
    /**
     * @Route("admin/home", name="admin-home")
     */
    public function generateView(Request $request){
        
        return $this->render('admin/home.html.twig');
    }
}