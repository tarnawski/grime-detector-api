<?php

namespace GrimeDetectorBundle\Service;

use Doctrine\ORM\EntityManager;
use GrimeDetectorBundle\Repository\StatisticRepository;
use GrimeDetectorBundle\Repository\WordRepository;
use GrimeDetectorBundle\Entity\Statistic;

class StatisticService
{
    /** @var WordRepository */
    private $wordRepository;

    /** @var  EntityManager */
    private $em;

    /** @var  StatisticRepository */
    private $statisticRepository;

    public function __construct(
        WordRepository $wordRepository,
        EntityManager $entityManager
    ) {
        $this->wordRepository = $wordRepository;
        $this->em = $entityManager;
        $this->statisticRepository = $entityManager->getRepository(Statistic::class);
    }

    public function getStatistic($key)
    {
        /** @var Statistic $statistic */
        $statistic = $this->statisticRepository->findByKey($key);

        return $statistic->getValue();
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