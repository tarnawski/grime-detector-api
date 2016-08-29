<?php

namespace Tarnawski\GrimeDetector\Processor;

use Tarnawski\GrimeDetector\Model\Word;
use Tarnawski\GrimeDetector\Model\Dictionary;
use Tarnawski\GrimeDetector\Normalizer\NormalizerFactory;
use Tarnawski\GrimeDetector\Tokenizer\WordTokenizer;

class DataProcessor
{
    const GRIME = 'grime';
    const HAM = 'ham';

    private $trainingData;

    /** @var WordTokenizer */
    private $wordTokenizer;

    /** @var NormalizerFactory */
    private $normalizer;


    public function __construct(
        WordTokenizer $wordTokenizer,
        NormalizerFactory $normalizerFactory
    ) {
        $this->wordTokenizer = $wordTokenizer;
        $this->normalizer = $normalizerFactory;
    }

    /**
     * @param mixed $path
     */
    public function loadTrainingData($path)
    {
        if (file_exists($path)) {
            $data = array_map('str_getcsv', file('/var/www/grime-detector/testdata.csv'));

            if (is_array($data)) {
                $this->trainingData =  $data;
            }
        }
    }

    public function process(){
        $dictionary = new Dictionary();

        foreach ($this->trainingData as $item) {
            if($item[0] == 0 ||  $item[0] == 4) {


                $text = $item[1];
                $type = $item[0] == 0 ? 'grime' : 'ham';

                $words = $this->wordTokenizer->tokenize($text);
                $words = $this->normalizer->normalize($words, ['LOWERCASE', 'STOP_WORDS', 'UNIQUE']);

                foreach ($words as $word) {
                    /** @var Word $wordObj */
                    $wordObj = $dictionary->getWord($word);
                    if ($wordObj) {
                        if ($type == self::GRIME) {
                            $wordObj->incrementGrimCount();
                        }
                        if ($type == self::HAM) {
                            $wordObj->incrementHamCount();
                        }
                    } else {
                        $wordObj = new Word($word);
                        if ($type == self::GRIME) {
                            $wordObj->incrementGrimCount();
                        }
                        if ($type == self::HAM) {
                            $wordObj->incrementHamCount();
                        }
                        $dictionary->addWord($wordObj);
                    }
                }
            }
        }

        return $dictionary;
    }
}