<?php

namespace GrimeDetectorBundle\Detector\Strategy;

use GrimeDetectorBundle\Detector\DetectorStrategy;
use GrimeDetectorBundle\Entity\Word;
use GrimeDetectorBundle\Repository\WordRepository;

class StaticStrategy implements DetectorStrategy
{
    /** @var WordRepository */
    private $wordRepository;

    /** @var string */
    private $language;

    public function __construct(WordRepository $wordRepository)
    {
        $this->wordRepository = $wordRepository;
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
