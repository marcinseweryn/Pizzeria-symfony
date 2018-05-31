<?php

namespace AppBundle\Controller\main;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $pizzas = $repository->findBy(['category' => 'pizza'],['price' => 'ASC']);
        
        return $this->render('main/home.html.twig',
            ['pizzas' => $pizzas]);
    }
}
