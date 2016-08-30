<?php

namespace Tarnawski\GrimeDetectorBundle\Entity;

class Word
{
    /** @var string */
    private $name;

    /** @var  integer */
    private $positive;

    /** @var  integer */
    private $negative;

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
    public function getPositive()
    {
        return $this->positive;
    }

    /**
     * @param int $positive
     */
    public function setPositive($positive)
    {
        $this->positive = $positive;
    }

    /**
     * @param int $value
     */
    public function incrementPositive($value = 1)
    {
        $this->positive += $value;
    }

    /**
     * @return int
     */
    public function getNegative()
    {
        return $this->negative;
    }

    /**
     * @param int $negative
     */
    public function setNegative($negative)
    {
        $this->negative = $negative;
    }

    /**
     * @param int $value
     */
    public function incrementNegative($value = 1)
    {
        $this->negative += $value;
    }
}
