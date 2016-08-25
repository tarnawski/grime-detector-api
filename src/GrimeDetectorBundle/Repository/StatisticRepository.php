<?php

namespace GrimeDetectorBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class StatisticRepository
 */
class StatisticRepository extends EntityRepository
{
    public function findByKey($key)
    {
        $result = $this->createQueryBuilder('s')
            ->select('s')
            ->where('s.key = :key')
            ->setParameter('key', $key)
            ->getQuery()
            ->getOneOrNullResult();

        return $result;
    }
}
