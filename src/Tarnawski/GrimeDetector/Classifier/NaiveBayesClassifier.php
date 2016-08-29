<?php

namespace Tarnawski\GrimeDetector\Classifier;

use Tarnawski\GrimeDetector\Model\Dictionary;

class NaiveBayesClassifier
{
    /** @var  Dictionary $dictionary) */
    private $dictionary;

    /**
     * @param Dictionary $dictionary
     */
    public function setDictionary(Dictionary $dictionary)
    {
        $this->dictionary = $dictionary;
    }

    public function classify($words)
    {
        $probabilityProducts = 1;
        $probabilitySums = 1;

        foreach($words as $word)
        {
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
        return $this->dictionary->getGrimeCount() / $this->dictionary->getWordsCount();
    }


    public function probabilityContentIsHam()
    {
        return $this->dictionary->getHamCount() / $this->dictionary->getWordsCount();
    }


    public function probabilityWordInGrime($word)
    {
        $word = $this->dictionary->getWord($word);
        if(!$word){
            return 0.5;
        }

        return $word->getGrimCount() / $this->dictionary->getGrimeCount();
    }


    public function probabilityWordInHam($word)
    {
        $word = $this->dictionary->getWord($word);
        if(!$word){
            return 0.5;
        }

        return $word->getHamCount() / $this->dictionary->getHamCount();
    }
}