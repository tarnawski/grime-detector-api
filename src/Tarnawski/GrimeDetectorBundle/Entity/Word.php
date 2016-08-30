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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getGrimeCount()
    {
        return $this->grimeCount;
    }

    /**
     * @param int $grimeCount
     */
    public function setGrimeCount($grimeCount)
    {
        $this->grimeCount = $grimeCount;
    }

    /**
     * @return int
     */
    public function getHamCount()
    {
        return $this->hamCount;
    }

    /**
     * @param int $hamCount
     */
    public function setHamCount($hamCount)
    {
        $this->hamCount = $hamCount;
    }
}
