<?php

namespace Tarnawski\GrimeDetectorBundle\Tokenizer;

interface Tokenizer
{
    /**
     * @param string $text
     */
    public function tokenize($text);
}
