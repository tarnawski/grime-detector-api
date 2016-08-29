<?php

namespace Tarnawski\GrimeDetector\Model;

class Dictionary
{
    /** @var array */
    private $words;

    public function __construct($words = [])
    {
        $this->words = $words;
    }

    /**
     * @return array
     */
    public function getWords()
    {
        return $this->words;
    }

    /**
     * @param array $words
     */
    public function setWords($words)
    {
        $this->words = $words;
    }

    /**
     * @param Word $word
     */
    public function addWord(Word $word)
    {
        $this->words[] = $word;
    }

    public function getWord($text)
    {
        /** @var Word $word */
        foreach ($this->words as $word){
            if($word->getName() == $text){
                return $word;
            }
        }

        return null;
    }

    public function getGrimeCount(){
        $grimeCount = 0;
        /** @var Word $word */
        foreach ($this->words as $word){
            if($word->getGrimCount() > $word->getHamCount()) {
                $grimeCount ++;
            }
        }

        return $grimeCount;
    }

    public function getHamCount(){
        $hamCount = 0;
        /** @var Word $word */
        foreach ($this->words as $word){
            if($word->getHamCount() > $word->getGrimCount()) {
                $hamCount ++;
            }
        }

        return $hamCount;
    }

    public function getWordsCount()
    {
        return count($this->getWords());
    }
}
