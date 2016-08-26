<?php

namespace Tarnawski\GrimeDetectorBundle\Corrector;

use Tarnawski\GrimeDetectorBundle\Entity\Word;
use Tarnawski\GrimeDetectorBundle\Repository\WordRepository;

class GrimeCorrector
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
     * @return string $text
     */
    public function correct($text, $language = null)
    {
        if (isset($language)) {
            $words = $this->wordRepository->getByLanguage($language);
        } else {
            $words = $this->wordRepository->findAll();
        }

        /** @var Word $word */
        foreach ($words as $word) {
            $censuredValue = $this->correctWord($word->getValue());
            $text = str_ireplace($word->getValue(), $censuredValue, $text);
        }

        return $text;
    }

    public function correctWord($word, $position = 1)
    {
        for ($i = $position; strlen($word) > $i; $i++) {
            if ($i >= 1) {
                $word[$i] = '*';
            }
        }

        return $word;
    }
}
