<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderProductRepository")
* @ORM\Table(name="order_product")
 */

class OrderProduct{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $orderProductID;
    
    /**
     * @ORM\Column(type="integer")
     */
    public $orderID;
    
    /**
     * @ORM\Column(type="integer")
     */
    public $productID;
    
    /**
     * @ORM\Column(type="string")
     */
    public $size;
    /**
     * @return mixed
     */
    public function getOrderProductID()
    {
        return $this->orderProductID;
    }

    /**
     * @return mixed
     */
    public function getOrderID()
    {
        return $this->orderID;
    }

    /**
     * @return mixed
     */
    public function getProductID()
    {
        return $this->productID;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $orderProductID
     */
    public function setOrderProductID($orderProductID)
    {
        $this->orderProductID = $orderProductID;
    }

    /**
     * @param mixed $orderID
     */
    public function setOrderID($orderID)
    {
        $this->orderID = $orderID;
    }

    /**
     * @param mixed $productID
     */
    public function setProductID($productID)
    {
        $this->productID = $productID;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }
    
}

