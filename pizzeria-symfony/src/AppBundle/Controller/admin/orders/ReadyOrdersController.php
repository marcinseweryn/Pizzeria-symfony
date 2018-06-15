<?php
namespace AppBundle\Controller\admin\orders;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Order;
use AppBundle\Service\Protection;

class ReadyOrdersController extends Controller{
    
    private $protection;
    
    public function __construct(){
        $this->protection = new Protection();
    }
    
    /**
     * @Route("admin/orders/ready-orders", name="admin-orders-ready-orders")
     */
    public function generateView(Request $request){
        $this->protection->userProtection($request);
        
        $em = $this->getDoctrine()->getManager();
        $ordersDetails = $em->getRepository(Order::class)->findOrdersDetailsByState('ready');
        
        return $this->render('admin/orders/ready-orders.html.twig',
            ['ordersDetails' => $ordersDetails]);
    }
    
    /**
     * @Route("admin/orders/ready-orders-action", name="admin-orders-ready-orders-action")
     */
    public function action(Request $request){
        $this->protection->userProtection($request);
        
        $orderID = substr($request->get('orderID'), 1);
        $action = substr($request->get('orderID'), 0, 1);
        
        $em = $this->getDoctrine()->getManager();

        if($action === "D"){
            $em->getRepository(Order::class)->updateOrderStateByOrderID('sended', $orderID);
        }else if($action === "U"){
            $em->getRepository(Order::class)->updateOrderStateByOrderID('uncompleted', $orderID);
        }else if ($action === "C"){
            $em->getRepository(Order::class)->updateOrderStateByOrderID('completed', $orderID);
        }
        
        return $this->redirectToRoute('admin-orders-ready-orders');
    }
}