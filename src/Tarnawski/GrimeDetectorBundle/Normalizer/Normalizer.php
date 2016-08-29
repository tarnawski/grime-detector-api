<?php

namespace Tarnawski\GrimeDetectorBundle\Normalizer;

interface Normalizer
{
    /**
     * @param array $words
     * @return array
     */
    public function normalize($words);
}
