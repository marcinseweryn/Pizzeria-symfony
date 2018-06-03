<?php

namespace AppBundle\Controller\user;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Order;
use AppBundle\Entity\OrderProduct;
use AppBundle\Entity\Product;
use AppBundle\Service\OrderService;
use AppBundle\Service\Protection;
use AppBundle\Entity\User;
use AppBundle\Service\OrderProductService;

class ConfirmOrderController extends Controller{
    
    private $orderService;
    private $orderProductService;
    private $protection;
    
    public function __construct(){
        $this->orderService = new OrderService();
        $this->orderProductService = new OrderProductService();
        $this->protection = new Protection();
    }
    
    /**
     * @Route("user/order/confirm", name="user-order-confirm")
     */
    public function generateView(Request $request){
        $this->protection->userProtection($request);
        $session = $request->getSession();
        $userID = $session->get('userID');
        $productID = $request->get('productID');

        $em = $this->getDoctrine()->getManager();
        
        $order = $em->getRepository(Order::class)->findOneBy(['userID' => $userID, 'state' => 'new']);
        $product = $em->getRepository(Product::class)->findOneBy(['productID' => $productID]);
        $user = $em->getRepository(User::class)->findOneBy(['id' => $userID]);
        
        $orderProductsDetails = $em->getRepository(OrderProduct::class)
        ->findOrderProductDetailsByOrderID($order->getOrderID());
        $orderProductsDetails = $this->orderProductService
        ->getOrderProductPriceDetailsByOrderProductsDetails($orderProductsDetails);
        
        $sum = $this->orderService->calculateOrderSum($orderProductsDetails);
        
        return $this->render('user/confirm-order.html.twig',
            ['orderProductsDetails' => $orderProductsDetails,
                'sum' => $sum,
                'product' => $product,
                'user' => $user
            ]);
    }
    
    
}