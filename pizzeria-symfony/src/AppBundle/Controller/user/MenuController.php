<?php
namespace AppBundle\Controller\user;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MenuController extends Controller{
    
    /**
     * @Route("user/menu", name="user-menu")
     */
    public function generateView(Request $request){
                
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $pizzas = $repository->findBy(['category' => 'pizza'],['price' => 'ASC']);
        $drinks = $repository->findBy(['category' => 'drinks'],['price' => 'ASC']);
        $fastFoods = $repository->findBy(['category' => 'fast food'],['price' => 'ASC']);
        
        return $this->render('user/menu.html.twig',
            ['pizzas' => $pizzas,
                'drinks' => $drinks,
                'fastFoods' => $fastFoods]);
    }
}