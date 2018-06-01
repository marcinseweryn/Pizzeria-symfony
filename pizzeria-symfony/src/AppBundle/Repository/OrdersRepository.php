<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Order;

class OrdersRepository extends EntityRepository
{
    public function findByID($orderID)
    {
        return $this->getEntityManager()
        ->createQuery(
            "SELECT o FROM AppBundle:Order o WHERE o.userID='${orderID}'"
            )
            ->getResult();
    }
    
    public function createNewOrderByUserID($userID){
        
        $order = new Order();
        $order->setUserID($userID);
        $order->setState('new');
        $order->setDelivery('new');
        $order->setSum(0);
        $order->setDate(date('Y-m-d H:i:s'));
        
        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();
    }
}