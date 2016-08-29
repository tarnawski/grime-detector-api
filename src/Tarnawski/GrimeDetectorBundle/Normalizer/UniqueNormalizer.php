<?php

namespace Tarnawski\GrimeDetectorBundle\Normalizer;

class UniqueNormalizer implements Normalizer
{
    public function normalize($words)
    {
        return array_unique($words);
    }
}
