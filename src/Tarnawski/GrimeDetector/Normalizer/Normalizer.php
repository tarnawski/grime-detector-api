<?php

namespace Tarnawski\GrimeDetector\Normalizer;

interface Normalizer
{
    /**
     * @param string $text
     * @return string
     */
    public function normalize($text);
}