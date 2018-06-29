<?php

namespace AppBundle\Service;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class Protection extends Controller{
    
    /**
     * @Route("user-protection", name="user-protection")
     */
    public function userProtection($request){
        $userRole = $request->getSession()->get('ROLE');
        if($userRole === 'ROLE_USER'){ 
        }else{
            exit();
        }
      
    }
    
    /**
     * @Route("admin-protection", name="admin-protection")
     */
    public function adminProtection($request){
        $userRole = $request->getSession()->get('ROLE');
        if($userRole === 'ROLE_USER'){
        }else{
            exit();
        }
        
    }
     
    
}