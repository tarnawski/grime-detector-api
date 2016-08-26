<?php

namespace Tarnawski\GrimeDetectorBundle\Service;

use Doctrine\ORM\EntityManager;
use Tarnawski\GrimeDetectorBundle\Repository\StatisticRepository;
use Tarnawski\GrimeDetectorBundle\Entity\Statistic;

class StatisticService
{
    /** @var  EntityManager */
    private $em;

    /** @var  StatisticRepository */
    private $statisticRepository;

    public function __construct( EntityManager $entityManager )
    {
        $this->em = $entityManager;
        $this->statisticRepository = $entityManager->getRepository(Statistic::class);
    }

    public function getStatistic($key)
    {
        /** @var Statistic $statistic */
        $statistic = $this->statisticRepository->findByKey($key);

        return $statistic ? $statistic->getValue() : null;
    }

    public function incrementStatistic($key, $value = 1)
    {
        /** @var Statistic $statistic */
        $statistic = $this->statisticRepository->findByKey($key);
        $newValue = (int)$statistic->getValue() + $value;
        $statistic->setValue($newValue);

        $this->em->persist($statistic);
        $this->em->flush();
    }
}