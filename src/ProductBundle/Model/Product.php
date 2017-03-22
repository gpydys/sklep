<?php

namespace ProductBundle\Model;

use DateTime;

class Product
{
    /**
     * @param $data
     * @return \ProductBundle\Entity\Product
     */
    static function fromArray($data){
        $product = new \ProductBundle\Entity\Product();
        $product->setName($data['name']);
        $product->setDescription($data['description']);
        $product->setPrice($data['price']);

        return $product;
    }
}

