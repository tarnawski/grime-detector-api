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
        $ps = $this->probabilityContentIsGrime();
        $ph = $this->probabilityContentIsHam();
        $pws = $this->probabilityWordInGrime($word);
        $pwh = $this->probabilityWordInHam($word);
        $psw = ($pws * $ps) / ($pws * $ps + $pwh * $ph);
        $psw = $psw == 1 ? 0.99 : $psw;
        $psw = $psw == 0 ? 0.01 : $psw;

        return $psw;
    }

    public function probabilityContentIsGrime()
    {
        return $this->wordRepository->getGrimeCount() / $this->wordRepository->getWordsCount();
    }

    public function probabilityContentIsHam()
    {
        return $this->wordRepository->getHamCount() / $this->wordRepository->getWordsCount();
    }


    public function probabilityWordInGrime($word)
    {
        /** @var Word $word */
        $word = $this->wordRepository->getWordByName($word);
        if (!$word) {
            return 0.5;
        }

        return $word->getGrimeCount() / $this->wordRepository->getGrimeCount();
    }


    public function probabilityWordInHam($word)
    {
        /** @var Word $word */
        $word = $this->wordRepository->getWordByName($word);
        if (!$word) {
            return 0.5;
        }

        return $word->getHamCount() / $this->wordRepository->getHamCount();
    }
}
