<?php

namespace AppBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="order")
 */

class Order{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $orderID;
    
    public $userID;
    public $date;
    public $state;
    public $delivery;
    public $sum;
}