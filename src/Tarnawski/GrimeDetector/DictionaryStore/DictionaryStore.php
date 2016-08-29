<?php

namespace Tarnawski\GrimeDetector\DictionaryStore;

use Tarnawski\GrimeDetector\Model\Dictionary;

interface DictionaryStore
{
    /**
     * @return mixed
     */
    public function read();

    /**
     * @param Dictionary $dictionary
     * @return mixed
     */
    public function write(Dictionary $dictionary);
}