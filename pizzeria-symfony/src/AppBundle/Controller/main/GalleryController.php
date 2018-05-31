<?php

namespace AppBundle\Controller\main;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GalleryController extends Controller{
    
    /**
     * @Route("gallery", name="gallery")
     */
    public function generateView(Request $request){
        
        return $this->render('main/gallery.html.twig');
    }
}