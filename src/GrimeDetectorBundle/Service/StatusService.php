<?php

namespace GrimeDetectorBundle\Service;

use GrimeDetectorBundle\Repository\WordRepository;

class StatusService
{
    /** @var WordRepository */
    private $wordRepository;

    public function __construct(WordRepository $wordRepository)
    {
        $this->wordRepository = $wordRepository;
    }

    public function getLanguagesCount()
    {
        return $this->wordRepository->getLanguageCount();
    }

    public function getCheckedTextCount()
    {
        return 250;
    }

    public function getGrimeFoundCount()
    {
        return 127;
    }
}