<?php

namespace Tarnawski\GrimeDetectorBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class CommentRepository
 */
class CommentRepository extends EntityRepository
{
    public function getCountUnprocessedComments()
    {
        $result = $this->createQueryBuilder('c')
            ->select('count(c)')
            ->where('c.processed = false')
            ->getQuery()
            ->getSingleScalarResult();

        return $result;
    }

    public function getUnprocessedComments($number = 10)
    {
        $result = $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.processed = false')
            ->setMaxResults($number)
            ->getQuery()
            ->getResult();

        return $result;
    }
}
