<?php

namespace Tarnawski\GrimeDetectorBundle\Detector;

use Tarnawski\GrimeDetectorBundle\Exception\DetectorException;

class StrategyFactory
{
    private $staticStrategy;

    const STATIC_STRATEGY = 'static';
    const CHECK_AND_REPLACE_STRATEGY = 'replace';

    public function __construct(
        DetectorStrategy $staticStrategy
    ) {
        $this->staticStrategy = $staticStrategy;
    }

    public function getStrategy($strategy)
    {
        switch ($strategy) {
            case self::STATIC_STRATEGY:
                return $this->staticStrategy;
                break;
            default:
                throw new DetectorException('Strategy "'.$strategy.'" not found!');
        }
    }
}
