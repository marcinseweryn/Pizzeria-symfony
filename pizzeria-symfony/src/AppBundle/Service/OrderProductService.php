<?php

namespace AppBundle\Service;

class OrderProductService{
     
    public function getOrderProductPriceDetailsByOrderProductsDetails($orderProductsDetails){
        
        if($orderProductsDetails != NULL){
            foreach($orderProductsDetails as $orderProduct){
                if($orderProduct["size"] === "S"){
                    $orderProduct["price"] =   $orderProduct["price"] * 0.7;
                }else if($orderProduct["size"] === "L"){
                    $orderProduct["price"] =   $orderProduct["price"] * 1.3;
                }
                $orderProducts2[] = $orderProduct; 
            }
            
            return $orderProducts2;
        }
        
        return NULL;
    }
    
}