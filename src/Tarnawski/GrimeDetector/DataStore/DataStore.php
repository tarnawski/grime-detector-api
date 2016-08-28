<?php

namespace Tarnawski\GrimeDetector\DataStore;

interface DataStore
{
    /**
     * @return mixed
     */
    public function read();

    /**
     * @param array $data
     * @return mixed
     */
    public function write($data);
}