<?php
namespace AppBundle\Controller\admin;

use AppBundle\Service\Protection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Product;

class ProductsController extends Controller{
    
    private $protection;
    
    public function __construct(){
        $this->protection = new Protection();
    }
    
    /**
     * @Route("admin/products", name="admin-products")
     */
    public function generateView(Request $request){
        $this->protection->userProtection($request);

        $em = $this->getDoctrine()->getManager();
        
        $products =  $em->getRepository(Product::class)->findBy([],['category'=>'DESC','price'=>'ASC']);
    
        return $this->render('admin/products.html.twig',
            ['products' => $products]);
    }
    
    /**
     * @Route("admin/products-action", name="admin-products-action")
     */
    public function action(Request $request){
        $this->protection->userProtection($request);
        
        $em = $this->getDoctrine()->getManager();
        
        $product = new Product();
        $product->setName($request->get("name"));
        $product->setCategory($request->get("category"));
        $product->setDescription($request->get("description"));
        $product->setPrice($request->get("price"));
        
        $action = $request->get('action');
        
        if($action === "create"){
            $em->persist($product);
            $em->flush();
        }else{   
            $productID = substr($action, 1);
            $action = substr($action, 0, 1);
            
            if($action === "D"){
                $em->remove($em->getRepository(Product::class)->find($productID));
                $em->flush();
            }else if($action === "U"){
                $product->setProductID($productID);
                $em->getRepository(Product::class)->updateProduct($product);
            }
        }   
        
        return $this->redirectToRoute('admin-products');
    }
}