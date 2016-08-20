<?php

namespace GrimeDetectorBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Expression
{
    /** @var integer */
    private $id;

    /** @var string */
    private $value;

    /** @var string */
    private $censuredValue;

    /** @var string */
    private $language;

    /**
     * @var ArrayCollection
     */
    private $types;

    public function __construct()
    {
        $this->types = new ArrayCollection();
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
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getCensuredValue()
    {
        return $this->censuredValue;
    }

    /**
     * @param string $censuredValue
     */
    public function setCensuredValue($censuredValue)
    {
        $this->censuredValue = $censuredValue;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param Type $type
     * @return Expression
     */
    public function addType(Type $type)
    {
        if (!$this->types->contains($type)) {
            $type->addExpression($this);
            $this->types[] = $type;
        }
        return $this;
    }

    /**
     * @param Type $type
     */
    public function removeType(Type $type)
    {
        $this->types->removeElement($type);
    }
}