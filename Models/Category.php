<?php
/**
 * Created by PhpStorm.
 * User: KA
 * Date: 1/25/2017
 * Time: 10:35 PM
 */

namespace Multidoc\Models;


class Category
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Category[]|null
     */
    private $categoryList;

    /**
     * @var Route[]
     */
    private $routeList;

    /**
     * Category constructor.
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
     * @return Category[]|null
     */
    public function getCategoryList()
    {
        return $this->categoryList;
    }

    /**
     * @param Category[]|null $categoryList
     */
    public function setCategoryList($categoryList)
    {
        $this->categoryList = $categoryList;
    }

    /**
     * @return Route[]
     */
    public function getRouteList()
    {
        return $this->routeList;
    }

    /**
     * @param Route[] $routeList
     */
    public function setRouteList($routeList)
    {
        $this->routeList = $routeList;
    }

    /**
     * @param Route $route
     */
    public function addRoute(Route $route)
    {
        $this->routeList[] = $route;
    }
}