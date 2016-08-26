<?php

namespace Tarnawski\GrimeDetectorBundle\DataStore\Strategy;

use Tarnawski\GrimeDetector\DataStore\DataStoreStrategy;

class JsonStrategy implements DataStoreStrategy
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
        $data = array();
        foreach ($data as $type => $texts) {
            foreach ($texts as $text) {
                $data[] = array(
                    'type' => $type,
                    'text' => $text
                );
            }
        }
        file_put_contents($this->path, json_encode($data));
    }
}