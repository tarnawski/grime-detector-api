<?php

namespace Tarnawski\GrimeDetector\Tokenizer;

interface Tokenizer
{
    /**
     * @param string $text
     */
    public function tokenize($text);
}