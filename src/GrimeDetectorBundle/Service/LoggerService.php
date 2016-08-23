<?php

namespace GrimeDetectorBundle\Service;

use Doctrine\ORM\EntityManager;
use GrimeDetectorBundle\Entity\CheckedData;

class LoggerService
{
    /** @var EntityManager */
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function logData(
        $text,
        $grime = false
    ) {
        $data = new CheckedData();
        $data->setText($text);
        $data->setGrime($grime);
        $this->em->persist($data);
        $this->em->flush();
    }
}