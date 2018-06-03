<?php

namespace AppBundle\Controller\user;

use AppBundle\Entity\Order;
use AppBundle\Service\OrderService;
use AppBundle\Service\Protection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CompletedOrderController extends Controller{
    
    private $orderService;
    private $protection;
    
    public function __construct(){
        $this->orderService = new OrderService();
        $this->protection = new Protection();
    }
    
    /**
     * @Route("user/order/completed", name="user-order-completed")
     */
    public function generateView(Request $request){
        $this->protection->userProtection($request);
        $session = $request->getSession();
        $userID = $session->get('userID');
        $sum = $request->get('sum');
       
        $em = $this->getDoctrine()->getManager();
        
        if($request->get('delivery') === "Yes"){
            $delivery = $request->get('city').", ".$request->get('address').", ".$request->get('postalCode');
        }else{
            $delivery = "Pickup in a pizzeria";
        }
        
        $order = $em->getRepository(Order::class)->findOneBy(['userID' => $userID, 'state' => 'new']);
        $em->getRepository(Order::class)->updateOrderStateDeliverySumByOrderID("waiting", $delivery, $sum, $order->orderID);
        
        return $this->render('user/completed-order.html.twig');
    }
    
}