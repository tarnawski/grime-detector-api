<?php

namespace Tarnawski\GrimeDetector\DataStore;

use Tarnawski\GrimeDetector\Exception\DataStoreException;
use Tarnawski\GrimeDetectorBundle\DataStore\Strategy\JsonStrategy;

class StrategyFactory
{
    public $jsonStrategy;

    const JSON_STRATEGY = 'json';

    public function __construct(JsonStrategy $jsonStrategy)
    {
        $this->jsonStrategy = $jsonStrategy;
    }

    public function getDefaultStrategy()
    {
        return $this->jsonStrategy;
    }

    public function getStrategy($strategy)
    {
        switch ($strategy) {
            case self::JSON_STRATEGY:
                return $this->jsonStrategy;
                break;
            default:
                throw new DataStoreException('Strategy "' . $strategy . '" not found!');
        }
    }
}