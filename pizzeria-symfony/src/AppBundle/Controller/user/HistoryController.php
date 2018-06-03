<?php

namespace AppBundle\Controller\user;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Order;
use AppBundle\Entity\OrderProduct;
use AppBundle\Service\OrderService;
use AppBundle\Service\Protection;

class HistoryController extends Controller{
    
    private $orderService;
    private $protection;
    
    public function __construct(){
        $this->orderService = new OrderService();
        $this->protection = new Protection();
    }
    
    /**
     * @Route("user/history", name="user-history")
     */
    public function generateView(Request $request){
        $this->protection->userProtection($request);
        $session = $request->getSession();
        $userID = $session->get('userID');
        $ordersProducts=NULL;
        
        $em = $this->getDoctrine()->getManager();
        
        $orders = $em->getRepository(Order::class)->findOrdersHistoryByUserID($userID);
        if($orders != NULL){
            foreach($orders as $order){
                $orderProductsDetails = $em->getRepository(OrderProduct::class)
                ->findOrderProductDetailsByOrderID($order->getOrderID());
                $ordersProducts[$order->orderID] = $orderProductsDetails;
            }
        }
        
        return $this->render('user/history.html.twig',
            ['ordersProducts' => $ordersProducts,
                'orders' => $orders
            ]);
    }
}