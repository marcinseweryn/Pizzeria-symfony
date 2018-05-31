<?php

namespace AppBundle\Controller\main;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MenuController extends Controller{
    
    /**
     * @Route("menu", name="menu")
     */
    public function generateView(Request $request){
           
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $pizzas = $repository->findBy(['category' => 'pizza'],['price' => 'ASC']);
        $drinks = $repository->findBy(['category' => 'drinks'],['price' => 'ASC']);
        $fastFoods = $repository->findBy(['category' => 'fast food'],['price' => 'ASC']);
        
        return $this->render('main/menu.html.twig',
            ['pizzas' => $pizzas,
             'drinks' => $drinks,
             'fastFoods' => $fastFoods]);
    }
}