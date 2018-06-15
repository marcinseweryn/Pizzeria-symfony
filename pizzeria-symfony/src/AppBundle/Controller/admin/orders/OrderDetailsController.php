<?php
namespace AppBundle\Controller\admin\orders;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\Protection;
use AppBundle\Entity\Order;
use AppBundle\Entity\OrderProduct;
use AppBundle\Service\OrderProductService;
use AppBundle\Entity\User;


class OrderDetailsController extends Controller{
    
    private $orderProductService;
    private $protection;
    
    public function __construct(){
        $this->protection = new Protection();
        $this->orderProductService = new OrderProductService();
    }
    
    /**
     * @Route("admin/orders/order-details", name="admin-orders-order-details")
     */
    public function generateView(Request $request){
        $this->protection->userProtection($request);
        $orderID = $request->get('orderID');
        $from = $request->get('from');
        
        $em = $this->getDoctrine()->getManager();
        
        $order = $em->getRepository(Order::class)->find($orderID);
        $orderProductsDetails = $em->getRepository(OrderProduct::class)
            ->findOrderProductDetailsByOrderID($orderID);
        $orderProductsDetails = $this->orderProductService
            ->getOrderProductPriceDetailsByOrderProductsDetails($orderProductsDetails);
        
        $user = $em->getRepository(User::class)->findOneBy(['id' => $order->getUserID()]);  
        
        return $this->render('admin/orders/order-details.html.twig',
            ['orderProductsDetails' => $orderProductsDetails,
                'user' => $user,
                'order' => $order,
                'from' => $from
            ]);
    }
    
    /**
     * @Route("admin/orders/order-details-action", name="admin-orders-order-details-action")
     */
    public function action(Request $request){
        $from = $request->get('from');
        
        $em = $this->getDoctrine()->getManager();
        
        if($from === "history"){
            return $this->redirectToRoute('admin-history');
        }else{
            $state = $request->get('state');
            $orderID = $request->get('orderID');
            
            $em->getRepository(Order::class)->updateOrderStateByOrderID($state, $orderID);
            
            if($from === "waiting"){
                return $this->redirectToRoute('admin-orders-waiting-orders');
            }else if($from === "queue"){
                return $this->redirectToRoute('admin-orders-queue-of-orders');
            }else if($from === "preparing"){
                return $this->redirectToRoute('admin-orders-preparing-orders');
            }else if($from === "ready"){
                return $this->redirectToRoute('admin-orders-ready-orders');
            }else if($from === "sended"){
                return $this->redirectToRoute('admin-orders-sended-orders');
            }
        }
    }
}