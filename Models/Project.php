<?php

namespace Multidoc\Models;

class Project
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $description;

    /**
     * @var Environment[]|null
     */
    private $environmentList;

    /**
     * @var Category[]
     */
    private $categoryList;

    /**
     * @var \DateTime
     */
    private $buildTime;

    /**
     * @var string
     */
    private $logo;

    /**
     * @var string
     */
    private $inputPath;

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
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return Environment[]|null
     */
    public function getEnvironmentList()
    {
        return $this->environmentList;
    }

    /**
     * @param Environment[]|null $environmentList
     */
    public function setEnvironmentList($environmentList)
    {
        $this->environmentList = $environmentList;
    }

    /**
     * @return Category[]
     */
    public function getCategoryList()
    {
        return $this->categoryList;
    }

    /**
     * @param Category[] $categoryList
     */
    public function setCategoryList($categoryList)
    {
        $this->categoryList = $categoryList;
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
     * @return \DateTime
     */
    public function getBuildTime()
    {
        return $this->buildTime;
    }

    /**
     * @param \DateTime $buildTime
     */
    public function setBuildTime($buildTime)
    {
        $this->buildTime = $buildTime;
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    public function setInputPath($path)
    {
        $this->inputPath = $path;
    }

    /**
     * @return string
     */
    public function getInputPath()
    {
        return $this->inputPath;
    }
}