<?php

namespace GrimeDetectorBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class CheckedDataRepository
 */
class CheckedDataRepository extends EntityRepository
{
    public function getCheckedTextCount()
    {
        $results = $this->createQueryBuilder('cd')
            ->select('count(cd)')
            ->getQuery()
            ->getSingleScalarResult();

        return $results;
    }

    public function getGrimeFoundCount()
    {
        $results = $this->createQueryBuilder('cd')
            ->select('count(cd)')
            ->where('cd.grime = true')
            ->getQuery()
            ->getSingleScalarResult();

        return $results;
    }
}
