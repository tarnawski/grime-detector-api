<?php

namespace Tarnawski\GrimeDetector\DictionaryStore;

use Tarnawski\GrimeDetector\Model\Dictionary;
use Tarnawski\GrimeDetector\Model\Word;

class JsonDictionaryStore implements DictionaryStore
{
    /** @var string */
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function read()
    {
        if (file_exists($this->path)) {
            $data = json_decode(file_get_contents($this->path), true);
            if (is_array($data)) {
                $dictionary = new Dictionary();
                foreach ($data as $item) {
                    $word = new Word(
                        $item['word'],
                        $item['grim_count'],
                        $item['ham_count']
                    );
                    $dictionary->addWord($word);
                }

                return $dictionary;
            }
        }

        return null;
    }

    public function write(Dictionary $dictionary)
    {
        $array = [];
        /** @var Word $word */
        foreach ($dictionary->getWords() as $word){
            $array[] = [
                'word' => $word->getName(),
                'grim_count' => $word->getGrimCount(),
                'ham_count' => $word->getHamCount()
            ];
        }
        file_put_contents($this->path, json_encode($array));
    }
}