<?php

namespace GrimeDetectorBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Type
{
    /** @var integer */
    private $id;

    /** @var string */
    private $name;

    /**
     * @var ArrayCollection
     */
    private $expressions;

    public function __construct()
    {
        $this->expressions = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
     * @return ArrayCollection
     */
    public function getExpressions()
    {
        return $this->expressions;
    }

    /**
     * @param Expression $expression
     * @return Type
     */
    public function addExpression(Expression $expression)
    {
        $this->expressions[] = $expression;

        return $this;
    }

    /**
     * @param Expression $expression
     */
    public function removeExpression(Expression $expression)
    {
        $this->expressions->removeElement($expression);
    }
}