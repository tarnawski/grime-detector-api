<?php

namespace Tarnawski\GrimeDetector\Normalizer;

class StopWordsNormalizer implements Normalizer
{
    const WORDS = ['the', 'to', 'you', 'he', 'only', 'if', 'it'];

    /**
     * @param array $array
     * @return array
     */
    public function normalize($array)
    {
        return array_diff($array, self::WORDS);
    }
}