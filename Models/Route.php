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
     * @var Status[]
     */
    private $statusList;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $inputPath;

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

    /**
     * @return Status[]
     */
    public function getStatusList()
    {
        return $this->statusList;
    }

    /**
     * @param Status[] $statusList
     */
    public function setStatusList($statusList)
    {
        $this->statusList = $statusList;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param Response $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
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