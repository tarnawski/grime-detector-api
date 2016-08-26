<?php

namespace Tarnawski\GrimeDetector\Normalizer;

class LowercaseNormalizer implements Normalizer
{
    public function normalize($text)
    {
        return mb_strtolower($text, 'utf-8');
    }
}