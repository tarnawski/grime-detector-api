<?php

namespace Tarnawski\GrimeDetectorBundle\Entity;

class Comment
{
    /** @var integer */
    private $id;

    /** @var string */
    private $content;

    /** @var boolean */
    private $positive;

    /** @var boolean */
    private $processed;

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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return boolean
     */
    public function isPositive()
    {
        return $this->positive;
    }

    /**
     * @param boolean $positive
     */
    public function setPositive($positive)
    {
        $this->positive = $positive;
    }

    /**
     * @return boolean
     */
    public function isProcessed()
    {
        return $this->processed;
    }

    /**
     * @param boolean $processed
     */
    public function setProcessed($processed)
    {
        $this->processed = $processed;
    }
}
