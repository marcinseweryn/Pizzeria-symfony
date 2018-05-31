<?php

namespace AppBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
* @ORM\Table(name="order_product")
 */

class OrderProduct{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $orderProductID;
    
    public $orderID;
    public $productID;
    public $size;
    
}

