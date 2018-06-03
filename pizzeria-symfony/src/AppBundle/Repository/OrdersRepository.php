<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Order;

class OrdersRepository extends EntityRepository
{
    
    public function createNewOrderByUserID($userID){
        
        $order = new Order();
        $order->setUserID($userID);
        $order->setState('new');
        $order->setDelivery('new');
        $order->setSum(0);
        $order->setDate(date_create(date('Y-m-d H:i:s')));
        
        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();
    }
    
    public function updateOrderStateDeliverySumByOrderID($state, $delivery, $sum, $orderID){
        $order = $this->getEntityManager()->getRepository(Order::class)->find($orderID);
        
        $order->setState($state);
        $order->setDelivery($delivery);
        $order->setSum($sum);
        $order->setDate(date_create(date('Y-m-d H:i:s')));
        
        $this->getEntityManager()->flush();
        
    }
    
    public function findOrdersInProgressByUserID($userID){
        return $this->getEntityManager()
        ->createQuery
        ("SELECT p FROM AppBundle:Order p
                        WHERE (p.userID ='${userID}') AND (p.state='waiting' OR p.state='queue'
                                OR p.state='preparing' OR p.state='sended' OR p.state='ready')")
                        ->getResult();
    }
    
    public function findOrdersHistoryByUserID($userID){
        return $this->getEntityManager()
        ->createQuery
        ("SELECT p FROM AppBundle:Order p
                        WHERE (p.userID ='${userID}') AND (p.state='reject' OR p.state='uncompleted'
                                OR p.state='completed')")
                                ->getResult();
    }
}