<?php

namespace AppBundle\Controller\user;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\Protection;

class HomeController extends Controller{
    
    private $protection;
    
    public function __construct(){
        $this->protection = new Protection();
    }
    
    /**
     * @Route("user/home", name="user-home")
     */
    public function generateView(Request $request){
        $this->protection->userProtection($request);
        return $this->render('user/home.html.twig');
    }
}