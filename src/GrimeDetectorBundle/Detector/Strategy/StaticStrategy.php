<?php

namespace GrimeDetectorBundle\Detector\Strategy;

use GrimeDetectorBundle\Detector\DetectorStrategy;
use GrimeDetectorBundle\Entity\Word;
use GrimeDetectorBundle\Repository\WordRepository;
use GrimeDetectorBundle\Service\StatisticService;

class StaticStrategy implements DetectorStrategy
{
    /** @var WordRepository */
    private $wordRepository;

    /** @var  StatisticService */
    private $statisticService;

    /** @var string */
    private $language;

    public function __construct(
        WordRepository $wordRepository,
        StatisticService $statisticService
    ) {
        $this->wordRepository = $wordRepository;
        $this->statisticService = $statisticService;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @param string $text
     * @param null $language
     * @return bool
     */
    public function check($text, $language = null)
    {
        $this->statisticService->incrementStatistic('TEXT_CHECKED');

        if (isset($language)) {
            $words = $this->wordRepository->getByLanguage($language);
        } else {
            $words = $this->wordRepository->findAll();
        }

        /** @var Word $word */
        foreach ($words as $word) {
            if (strripos($text, $word->getValue()) !== false) {

                return false;
            }
        }

        return true;
    }
}
