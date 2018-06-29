<?php
namespace AppBundle\Controller\admin\orders;

use AppBundle\Entity\Order;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\Protection;

class WaitingOrdersController extends Controller{
    
    private $protection;
    
    public function __construct(){
        $this->protection = new Protection();
    }
    
    /**
     * @Route("admin/orders/waiting-orders", name="admin-orders-waiting-orders")
     */
    public function generateView(REquest $request){
        $this->protection->adminProtection($request);
        
        $em = $this->getDoctrine()->getManager();
        $ordersDetails = $em->getRepository(Order::class)->findOrdersDetailsByState('waiting');
        
        return $this->render('admin/orders/waiting-orders.html.twig',
            ['ordersDetails' => $ordersDetails]);
    }
}