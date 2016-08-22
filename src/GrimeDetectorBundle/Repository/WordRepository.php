<?php

namespace GrimeDetectorBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class WordRepository
 */
class WordRepository extends EntityRepository
{
    public function getByLanguage($language)
    {
        $results = $this->createQueryBuilder('w')
            ->select('w')
            ->where('w.language = :language')
            ->setParameter('language', $language)
            ->getQuery()
            ->getResult();

        return $results;
    }

    public function getLanguageCount()
    {
        $results = $this->createQueryBuilder('w')
            ->select('count(w.language)')
            ->distinct()
            ->getQuery()
            ->getSingleScalarResult();

        return $results;
    }
}
