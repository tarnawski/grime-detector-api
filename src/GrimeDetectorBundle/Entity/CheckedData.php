<?php

namespace GrimeDetectorBundle\Entity;

class CheckedData
{
    /** @var integer */
    private $id;

    /** @var string */
    private $text;

    /** @var bool */
    private $grime;

    /** @var bool */
    private $spam;

    /** @var \DateTime */
    private $date;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return boolean
     */
    public function isGrime()
    {
        return $this->grime;
    }

    /**
     * @param boolean $grime
     */
    public function setGrime($grime)
    {
        $this->grime = $grime;
    }

    /**
     * @return boolean
     */
    public function isSpam()
    {
        return $this->spam;
    }

    /**
     * @param boolean $spam
     */
    public function setSpam($spam)
    {
        $this->spam = $spam;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
}
