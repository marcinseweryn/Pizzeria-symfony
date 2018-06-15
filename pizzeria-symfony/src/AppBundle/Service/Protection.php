<?php

namespace AppBundle\Service;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class Protection extends Controller{
    
    /**
     * @Route("protection", name="protection")
     */
    public function userProtection($request){
        $userRole = $request->getSession()->get('ROLE');
        if($userRole === 'ROLE_USER'){
            
        }else if($userRole === 'ROLE_ADMIN'){
            
        }else{
            exit();
        }
        
    }
     
    
}