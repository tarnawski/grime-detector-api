<?php

namespace Tarnawski\GrimeDetector\Tokenizer;

class WordTokenizer implements Tokenizer
{
    public function tokenize($text)
    {
        return preg_split('/\PL+/u', $text, null, PREG_SPLIT_NO_EMPTY);
    }
}