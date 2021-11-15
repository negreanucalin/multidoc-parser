<?php
/**
 * Created by PhpStorm.
 * User: KA
 * Date: 1/26/2017
 * Time: 8:30 AM
 */

namespace Multidoc\Models;


class Parameter
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var int|string
     */
    private $dataType;

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var bool
     */
    private $isOptional = false;

    /**
     * @var int|string
     */
    private $example = '';

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
     * @return int|string
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * @param int|string $dataType
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return boolean
     */
    public function isIsOptional()
    {
        return $this->isOptional;
    }

    /**
     * @param boolean $isOptional
     */
    public function setIsOptional($isOptional)
    {
        $this->isOptional = $isOptional;
    }

    /**
     * @return int|string
     */
    public function getExample()
    {
        return $this->example;
    }

    /**
     * @param int|string $example
     */
    public function setExample($example)
    {
        $this->example = $example;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}