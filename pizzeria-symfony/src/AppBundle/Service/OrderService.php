<?php
namespace AppBundle\Service;

use AppBundle\Service\OrderProductService;

class OrderService
{
    private $orderProductService;
    
    public function __construct(){
        $this->orderProductService = new OrderProductService();
    }
    
    public function getOrdersArrayOfProductOrdersTables($orders){
        if($orders != NULL){
            foreach($orders as $order){
                $orderProducts[] = $order->orderID;
                
                $productsDetails = $this->orderProductService->findOrderProductDetailsByOrderID($order->orderID);
    
                $orderProducts[$order->orderID] = $productsDetails;
            }
            return $orderProducts;
        }else{
            return NULL;
        }
    }
    
    public function updateOrderSumByOrderID($orderID){
        
        $sum = $this->calculateOrderSum($orderID);
        
        $this->orderDAO->updateOrderSumByOrderID($orderID, $sum);
    }
    
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

