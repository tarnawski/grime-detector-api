<?php

namespace GrimeDetectorBundle\Service;

use GrimeDetectorBundle\Repository\CheckedDataRepository;
use GrimeDetectorBundle\Repository\WordRepository;

class StatusService
{
    /** @var WordRepository */
    private $wordRepository;

    /** @var  CheckedDataRepository */
    private $checkedDataRepository;

    public function __construct(
        WordRepository $wordRepository,
        CheckedDataRepository $checkedDataRepository
    ) {
        $this->wordRepository = $wordRepository;
        $this->checkedDataRepository = $checkedDataRepository;
    }

    public function getLanguagesCount()
    {
        return $this->wordRepository->getLanguagesCount();
    }

    public function getCheckedTextCount()
    {
        return $this->checkedDataRepository->getCheckedTextCount();
    }

    public function getGrimeFoundCount()
    {
        return $this->checkedDataRepository->getGrimeFoundCount();
    }
}