<?php

namespace GrimeDetectorBundle\Detector;

interface DetectorStrategy
{
    /**
     * @param string $text
     * @param string $language
     * @return bool
     */
    public function check($text, $language);
}
