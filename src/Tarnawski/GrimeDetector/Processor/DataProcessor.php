<?php

namespace Tarnawski\GrimeDetector\Processor;

use Tarnawski\GrimeDetector\Model\Word;
use Tarnawski\GrimeDetector\Model\WordCollection;
use Tarnawski\GrimeDetector\Normalizer\LowercaseNormalizer;
use Tarnawski\GrimeDetector\Normalizer\StopWordsNormalizer;
use Tarnawski\GrimeDetector\Normalizer\UniqueNormalizer;
use Tarnawski\GrimeDetector\Tokenizer\WordTokenizer;
use Tarnawski\GrimeDetector\DataStore\JsonStore;

class DataProcessor
{
    const GRIME = 'grime';
    const HAM = 'ham';

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
    }

    public function read($path)
    {
        if (file_exists($path)) {
            $data = json_decode(file_get_contents($path), true);
            if (is_array($data)) {
                return $data;
            }
        }

        return [];
    }

    public function prepare($stringWords)
    {
        $arrayWords = $this->wordTokenizer->tokenize($stringWords);
        $arrayWords = $this->lowercaseNormalizer->normalize($arrayWords);
        $arrayWords = $this->stopWordsNormalizer->normalize($arrayWords);
        $arrayWords = $this->uniqueNormalizer->normalize($arrayWords);

        return $arrayWords;
    }

    public function process($data){
        $wordCollection = new WordCollection();

        foreach ($data as $item) {
            $text = isset($item['text']) ? $item['text'] : '';
            $type = isset($item['type']) ? $item['type'] : '';

            $words = $this->prepare($text);

            foreach ($words as $word){
                /** @var Word $wordObj */
                $wordObj = $wordCollection->getWord($word);
                if($wordObj){
                    if ($type == self::GRIME ) {
                        $wordObj->incrementGrimCount();
                    }
                    if ($type == self::HAM ) {
                        $wordObj->incrementHamCount();
                    }
                } else {
                    $wordObj = new Word($word);
                    if ($type == self::GRIME ) {
                        $wordObj->incrementGrimCount();
                    }
                    if ($type == self::HAM ) {
                        $wordObj->incrementHamCount();
                    }
                    $wordCollection->addWord($wordObj);
                }
            }
        }

        $wordArray = $wordCollection->toArray();

        $this->jsonStore->write($wordArray);
    }
}