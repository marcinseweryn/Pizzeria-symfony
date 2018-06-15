<?php
namespace AppBundle\Controller\admin;

use AppBundle\Entity\Order;
use AppBundle\Service\Protection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HistoryController extends Controller{

    private $protection;
    
    public function __construct(){
        $this->protection = new Protection();
    }
    
    /**
     * @Route("admin/history", name="admin-history")
     */
    public function generateView(Request $request){
        $this->protection->userProtection($request);
        
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository(Order::class)->findOrdersHistory();
    
        return $this->render('admin/history.html.twig',
            ['orders' => $orders]);
    }
}