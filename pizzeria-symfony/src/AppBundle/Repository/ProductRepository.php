<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Product;

class ProductRepository extends EntityRepository
{

    
    public function updateProduct(Product $product){
        $p = $this->getEntityManager()->getRepository(Product::class)->find($product->getProductID());
        
        $p->setName($product->getName());
        $p->setDescription($product->getDescription());
        $p->setPrice($product->getPrice());
        $p->setCategory($product->getCategory());
        
        $this->getEntityManager()->flush();
        
    } 

}