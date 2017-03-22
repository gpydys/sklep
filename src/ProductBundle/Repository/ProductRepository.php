<?php

namespace ProductBundle\Repository;

use Doctrine\ORM\EntityRepository;
use ProductBundle\Entity\Product;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends EntityRepository
{
    /**
     * @return Product[]
     */
    public function getAllSortDesc()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('q')
            ->from('ProductBundle:Product', 'q')
            ->orderBy('q.createdAt', 'DESC');

        return $qb->getQuery()->getResult();
    }
}