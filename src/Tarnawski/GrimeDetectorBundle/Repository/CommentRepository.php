<?php

namespace Tarnawski\GrimeDetectorBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class CommentRepository
 */
class CommentRepository extends EntityRepository
{
    public function getPUnprocessedComments($number = 10)
    {
        $result = $this->createQueryBuilder('w')
            ->select('w')
            ->where('w.processed = false')
            ->setMaxResults($number)
            ->getQuery()
            ->getOneOrNullResult();

        return $result;
    }
}
