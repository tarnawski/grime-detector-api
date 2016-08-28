<?php

namespace Tarnawski\GrimeDetector\Classifier;

use Tarnawski\GrimeDetector\DataStore\JsonStore;
use Tarnawski\GrimeDetector\Model\WordCollection;
use Tarnawski\GrimeDetector\Normalizer\LowercaseNormalizer;
use Tarnawski\GrimeDetector\Normalizer\StopWordsNormalizer;
use Tarnawski\GrimeDetector\Normalizer\UniqueNormalizer;
use Tarnawski\GrimeDetector\Tokenizer\WordTokenizer;

class NaiveBayesClassifier
{
    /** @var JsonStore */
    private $jsonStore;

    /** @var WordTokenizer */
    private $wordTokenizer;

    /** @var LowercaseNormalizer */
    private $lowercaseNormalizer;

    /** @var StopWordsNormalizer */
    private $stopWordsNormalizer;

    /** @var UniqueNormalizer */
    private $uniqueNormalizer;

    private $wordCollection;

    public function __construct(
        JsonStore $jsonStore,
        WordTokenizer $wordTokenizer,
        LowercaseNormalizer $lowercaseNormalizer,
        StopWordsNormalizer $stopWordsNormalizer,
        UniqueNormalizer $uniqueNormalizer
    ) {
        $this->jsonStore = $jsonStore;
        $this->wordTokenizer = $wordTokenizer;
        $this->lowercaseNormalizer = $lowercaseNormalizer;
        $this->stopWordsNormalizer = $stopWordsNormalizer;
        $this->uniqueNormalizer = $uniqueNormalizer;
        $this->data = $jsonStore->read();
        $this->wordCollection = new WordCollection();
        $this->wordCollection->fromArray($this->data);
    }

    public function classify($text)
    {
        $probabilityProducts = 1;
        $probabilitySums = 1;
        $words = $this->prepare($text);

        foreach($words as $word)
        {
            $probability = $this->wordProbability($word);
            $probabilityProducts *= $probability;
            $probabilitySums *= (1 - $probability);
        }

        $grimeProbability = $probabilityProducts / ($probabilityProducts + $probabilitySums);

        return round($grimeProbability, 2);
    }

    public function prepare($stringWords)
    {
        $arrayWords = $this->wordTokenizer->tokenize($stringWords);
        $arrayWords = $this->lowercaseNormalizer->normalize($arrayWords);
        $arrayWords = $this->stopWordsNormalizer->normalize($arrayWords);
        $arrayWords = $this->uniqueNormalizer->normalize($arrayWords);

        return $arrayWords;
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
        return $this->wordCollection->getGrimeCount() / $this->wordCollection->getWordsCount();
    }


    public function probabilityContentIsHam()
    {
        return $this->wordCollection->getHamCount() / $this->wordCollection->getWordsCount();
    }


    public function probabilityWordInGrime($word)
    {
        $word = $this->wordCollection->getWord($word);
        if(!$word){
            return 0.5;
        }

        return $word->getGrimCount() / $this->wordCollection->getGrimeCount();
    }


    public function probabilityWordInHam($word)
    {
        $word = $this->wordCollection->getWord($word);
        if(!$word){
            return 0.5;
        }

        return $word->getHamCount() / $this->wordCollection->getHamCount();
    }
}