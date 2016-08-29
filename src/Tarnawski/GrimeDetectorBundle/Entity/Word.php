<?php

namespace Tarnawski\GrimeDetectorBundle\Entity;

class Word
{
    /** @var string */
    private $name;

    /** @var  integer */
    private $grimeCount;

    /** @var  integer */
    private $hamCount;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getGrimeCount()
    {
        return $this->grimeCount;
    }

    /**
     * @return int
     */
    public function getHamCount()
    {
        return $this->hamCount;
    }
}
