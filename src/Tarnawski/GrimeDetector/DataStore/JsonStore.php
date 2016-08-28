<?php

namespace Tarnawski\GrimeDetector\DataStore;

class JsonStore implements DataStore
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
                return $data;
            }
        }

        return [];
    }

    public function write($data)
    {
        file_put_contents($this->path, json_encode($data));
    }
}