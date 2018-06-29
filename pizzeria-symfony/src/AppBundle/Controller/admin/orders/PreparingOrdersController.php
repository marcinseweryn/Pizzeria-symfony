<?php
namespace AppBundle\Controller\admin\orders;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Order;
use AppBundle\Service\Protection;


class PreparingOrdersController extends Controller{
    
    private $protection;
    
    public function __construct(){
        $this->protection = new Protection();
    }
    
    /**
     * @Route("admin/orders/preparing-orders", name="admin-orders-preparing-orders")
     */
    public function generateView(Request $request){
        $this->protection->adminProtection($request);
        
        $em = $this->getDoctrine()->getManager();
        $ordersDetails = $em->getRepository(Order::class)->findOrdersDetailsByState('preparing');
        
        return $this->render('admin/orders/preparing-orders.html.twig',
            ['ordersDetails' => $ordersDetails]);
    }
    
    /**
     * @Route("admin/orders/preparing-orders-ready", name="admin-orders-preparing-orders-ready")
     */
    public function orderReady(Request $request){
        $this->protection->adminProtection($request);
        $orderID = $request->get('orderID');
        
        $em = $this->getDoctrine()->getManager();
        $em->getRepository(Order::class)->updateOrderStateByOrderID('ready', $orderID);
        
        return $this->redirectToRoute('admin-orders-preparing-orders');
    }
}