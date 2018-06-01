<?php
namespace AppBundle\Controller\user;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Order;
use AppBundle\Entity\OrderProduct;
use AppBundle\Entity\Product;
use AppBundle\Service\OrderProductService;
use AppBundle\Service\OrderService;

class OrdersController extends Controller{
    
    private $orderProductService;
    private $orderService;
    
    public function __construct(){
        $this->orderService = new OrderService();
        $this->orderProductService = new OrderProductService();
    }

    /**
     * @Route("user/order", name="user-order")
     */
    public function generateView(Request $request){
        $session = $request->getSession();
        $userID = $session->get('userID');
        $productID = $request->get('productID');
        
        $em = $this->getDoctrine()->getManager();
        
        $order = $em->getRepository(Order::class)->findOneBy(['userID' => $userID, 'state' => 'new']);
        $product = $em->getRepository(Product::class)->findOneBy(['productID' => $productID]);
        
        if($order == NULL){
            $orderProductsDetails = NULL;
            $sum = 0;
        }else{
            $orderProductsDetails = $em->getRepository(OrderProduct::class)
                ->findOrderProductDetailsByOrderID($order->getOrderID());
            $orderProductsDetails = $this->orderProductService
                ->getOrderProductPriceDetailsByOrderProductsDetails($orderProductsDetails);

            $sum = $this->orderService->calculateOrderSum($orderProductsDetails);
        }
        
        return $this->render('user/orders.html.twig',
            ['orderProductsDetails' => $orderProductsDetails,
                'sum' => $sum,
                'product' => $product
            ]);
        
    }
    
    /**
     * @Route("user/order/add", name="user-order-add")
     */
    public function addToOrder(Request $request){       
        $em = $this->getDoctrine()->getManager();
        
        if($request->get('action')==="add"){
            $session = $request->getSession();
            $userID = $session->get('userID');
            $productID = $request->get('productID');
            
            $order = $em->getRepository(Order::class)->findOneBy(['userID' => $userID, 'state' => 'new']);
            
            if($order==NULL){
                $em->getRepository(Order::class)->createNewOrderByUserID($userID);
                $order = $em->getRepository(Order::class)->findOneBy(['userID' => $userID, 'state' => 'new']);
            }
            $orderProduct = new OrderProduct();
            $orderProduct->setOrderID($order->getOrderID());
            $orderProduct->setProductID($productID);
            $orderProduct->setSize($request->get('size'));
            
            $em->persist($orderProduct);
            $em->flush();
            
            return $this->redirectTORoute('user-order', ['productID' => $productID]);
        }else{
            return $this->redirectToRoute('user-menu');
        }
    }
    

    /**
     * @Route("user/order/remove", name="user-order-remove")
     */
    public function removeFromOrder(Request $request){  
        $em = $this->getDoctrine()->getManager();
        $productID = $request->get('productID');
       
        $orderProduct = $em->getReference(OrderProduct::class, $request->get('remove'));
        $em->remove($orderProduct);
        $em->flush();
        
        return $this->redirectTORoute('user-order', ['productID' => $productID]);
    }
    
    /**
     * @Route("user/order/send", name="user-order-send")
     */
    public function sendOrder(Request $request){
        $session = $request->getSession();
        $userID = $session->get('userID');
        $productID = $request->get('productID');
        
        $em = $this->getDoctrine()->getManager();
        
        if( $request->get('action')==="order"){
            return $this->redirectTORoute('user-order-confirm',['productID' => $productID]);
        }else{
            $order = $em->getRepository(Order::class)->findOneBy(['userID' => $userID, 'state' => 'new']);
            $em->getRepository(OrderProduct::class)->deleteProductFromOrderProductByOrderID($order->getOrderID());
            return $this->redirectToRoute('user-menu');
        }
    }
}