<?php
/**
 * Created by PhpStorm.
 * User: KA
 * Date: 1/25/2017
 * Time: 10:23 PM
 */

namespace Multidoc\Models;


class Route
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $method;

    /**
     * @var Parameter[]
     */
    private $parameterList;

    /**
     * @var Tag[]
     */
    private $tagList;

    /**
     * @var Category[]
     */
    private $category;

    /**
     * For internal use
     * @var string
     */
    private $categoryId;

    /**
     * @var int
     */
    private $id;

    /**
     * Route constructor.
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return Parameter[]
     */
    public function getParameterList()
    {
        return $this->parameterList;
    }

    /**
     * @param Parameter[] $parameterList
     */
    public function setParameterList($parameterList)
    {
        $this->parameterList = $parameterList;
    }

    /**
     * @return Category[]
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param string $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return Tag[]
     */
    public function getTagList()
    {
        return $this->tagList;
    }

    /**
     * @param Tag[] $tagList
     */
    public function setTagList($tagList)
    {
        $this->tagList = $tagList;
    }
}