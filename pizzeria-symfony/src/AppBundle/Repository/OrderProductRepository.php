<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class OrderProductRepository extends EntityRepository
{
    public function findOrderProductDetailsByOrderID($orderID)
    {
        return $this->getEntityManager()
        ->createQuery
            ("SELECT p.productID, p.name, p.price, op.orderID, op.orderProductID, op.size
                FROM AppBundle:Product p
                   JOIN AppBundle:OrderProduct op WITH op.productID=p.productID
                        WHERE op.orderID ='${orderID}'")
                            ->getResult();
    }
    
    public function deleteProductFromOrderProductByOrderID($orderID){
        $query = $this->getEntityManager()
        ->createQuery(
            "DELETE FROM AppBundle:OrderProduct o WHERE o.orderID='${orderID}'"
        );
        $query->execute();
    }
}