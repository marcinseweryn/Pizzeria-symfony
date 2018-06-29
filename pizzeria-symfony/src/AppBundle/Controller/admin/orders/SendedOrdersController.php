<?php
namespace AppBundle\Controller\admin\orders;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Order;
use AppBundle\Service\Protection;

class SendedOrdersController extends Controller{
    
    private $protection;
    
    public function __construct(){
        $this->protection = new Protection();
    }
    
    /**
     * @Route("admin/orders/sended-orders", name="admin-orders-sended-orders")
     */
    public function generateView(Request $request){
        $this->protection->adminProtection($request);
        
        $em = $this->getDoctrine()->getManager();
        $ordersDetails = $em->getRepository(Order::class)->findOrdersDetailsByState('sended');
        
        return $this->render('admin/orders/sended-orders.html.twig',
            ['ordersDetails' => $ordersDetails]);
    }
    
    /**
     * @Route("admin/orders/sended-orders-action", name="admin-orders-sended-orders-action")
     */
    public function action(Request $request){
        $this->protection->adminProtection($request);
        
        $orderID = substr($request->get('orderID'), 1);
        $action = substr($request->get('orderID'), 0, 1);
        
        $em = $this->getDoctrine()->getManager();
        
        if($action === "U"){
            $em->getRepository(Order::class)->updateOrderStateByOrderID('uncompleted', $orderID);
        }else if ($action === "C"){
            $em->getRepository(Order::class)->updateOrderStateByOrderID('completed', $orderID);
        }
        
        return $this->redirectToRoute('admin-orders-ready-orders');
    }
}