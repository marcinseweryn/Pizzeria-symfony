<?php
namespace AppBundle\Service;


class OrderService
{
   
    public function calculateOrderSum($orderProductsDetails){
        
        $productsDetails = $orderProductsDetails;
        $sum = 0;
        if($productsDetails != NULL){
            foreach($productsDetails as $productDetail){
                $sum = $sum + $productDetail["price"];
            }
            
            return $sum;
        }
        return NULL;
    }
    
    
}

