<?php
namespace AppBundle\Controller\admin\orders;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Order;
use AppBundle\Service\Protection;

class QueueOfOrdersController extends Controller{
    
    private $protection;
    
    public function __construct(){
        $this->protection = new Protection();
    }
    
    /**
     * @Route("admin/orders/queue-of-orders", name="admin-orders-queue-of-orders")
     */
    public function generateView(Request $request){        
        $this->protection->adminProtection($request);
        
        $em = $this->getDoctrine()->getManager();
        $ordersDetails = $em->getRepository(Order::class)->findOrdersDetailsByState('queue');
        
        return $this->render('admin/orders/queue-of-orders.html.twig',
            ['ordersDetails' => $ordersDetails]);
    }
    
    /**
     * @Route("admin/orders/queue-of-orders-preparing", name="admin-orders-queue-of-orders-preparing")
     */
    public function prepareOrder(Request $request){       
        $this->protection->adminProtection($request);
        $orderID = $request->get('orderID');
        
        $em = $this->getDoctrine()->getManager();
        $em->getRepository(Order::class)->updateOrderStateByOrderID('preparing', $orderID);
        
        return $this->redirectToRoute('admin-orders-queue-of-orders');
    }
    
}