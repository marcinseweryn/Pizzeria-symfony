<?php

namespace AppBundle\Controller\admin;

use AppBundle\Service\Protection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller{
    
    private $protection;
    
    public function __construct(){
        $this->protection = new Protection();
    }
    
    /**
     * @Route("admin/home", name="admin-home")
     */
    public function generateView(Request $request){
        $this->protection->adminProtection($request);
        
        return $this->render('admin/home.html.twig');
    }
}