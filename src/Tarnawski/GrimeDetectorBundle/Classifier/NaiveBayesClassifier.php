<?php

namespace Tarnawski\GrimeDetectorBundle\Classifier;

use Tarnawski\GrimeDetectorBundle\Entity\Word;
use Tarnawski\GrimeDetectorBundle\Repository\WordRepository;

class NaiveBayesClassifier
{
    /** @var WordRepository $wordRepository */
    private $wordRepository;

    public function __construct(WordRepository $wordRepository)
    {
        $this->wordRepository = $wordRepository;
    }

    public function classify($words)
    {
        $probabilityProducts = 1;
        $probabilitySums = 1;

        foreach ($words as $word) {
            $probability = $this->wordProbability($word);
            $probabilityProducts *= $probability;
            $probabilitySums *= (1 - $probability);
        }

        $grimeProbability = $probabilityProducts / ($probabilityProducts + $probabilitySums);

        return round($grimeProbability, 2);
    }

    public function wordProbability($word)
    {
        $ps = $this->probabilityContentIsNegative();
        $ph = $this->probabilityContentIsPositive();
        $pws = $this->probabilityWordInNegative($word);
        $pwh = $this->probabilityWordInPositive($word);
        $psw = ($pws * $ps) / ($pws * $ps + $pwh * $ph);
        $psw = $psw == 1 ? 0.99 : $psw;
        $psw = $psw == 0 ? 0.01 : $psw;

        return $psw;
    }

    public function probabilityContentIsNegative()
    {
        return $this->wordRepository->getNegativeCount() / $this->wordRepository->getWordsCount();
    }

    public function probabilityContentIsPositive()
    {
        return $this->wordRepository->getPositiveCount() / $this->wordRepository->getWordsCount();
    }


    public function probabilityWordInNegative($word)
    {
        /** @var Word $word */
        $word = $this->wordRepository->getWordByName($word);
        if (!$word) {
            return 0.5;
        }

        return $word->getNegative() / $this->wordRepository->getNegativeCount();
    }


    public function probabilityWordInPositive($word)
    {
        /** @var Word $word */
        $word = $this->wordRepository->getWordByName($word);
        if (!$word) {
            return 0.5;
        }

        return $word->getPositive() / $this->wordRepository->getPositiveCount();
    }
}
