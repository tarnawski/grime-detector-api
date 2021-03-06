<?php

namespace Tarnawski\GrimeDetectorBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class WordRepository
 */
class WordRepository extends EntityRepository
{
    public function getWordsCount()
    {
        $result = $this->createQueryBuilder('w')
            ->select('count(w)')
            ->getQuery()
            ->getSingleScalarResult();

        return (int)$result;
    }

    public function getWordByName($name)
    {
        $result = $this->createQueryBuilder('w')
            ->select('w')
            ->where('w.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();

        return $result;
    }

    public function getGrimeCount()
    {
        $result = $this->createQueryBuilder('w')
            ->select('count(w)')
            ->where('w.grimeCount > w.hamCount')
            ->getQuery()
            ->getSingleScalarResult();

        return (int)$result;
    }

    public function getHamCount()
    {
        $result = $this->createQueryBuilder('w')
            ->select('count(w)')
            ->where('w.grimeCount < w.hamCount')
            ->getQuery()
            ->getSingleScalarResult();

        return (int)$result;
    }
}
