<?php

namespace Tarnawski\GrimeDetector\Model;

class Word
{
    /** @var string */
    private $name;

    /** @var integer */
    private $grimCount;

    /** @var integer */
    private $hamCount;

    public function __construct($name, $grimCount = 0, $hamCount = 0)
    {
        $this->name = $name;
        $this->grimCount = $grimCount;
        $this->hamCount = $hamCount;
    }

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
    public function getGrimCount()
    {
        return $this->grimCount;
    }

    /**
     * @param int $grimCount
     */
    public function setGrimCount($grimCount)
    {
        $this->grimCount = $grimCount;
    }

    /**
     * @param int $value
     */
    public function incrementGrimCount($value = 1)
    {
        $this->grimCount += $value;
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

    /**
     * @param int $value
     */
    public function incrementHamCount($value = 1)
    {
        $this->hamCount += $value;
    }
}
