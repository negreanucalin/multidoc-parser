<?php

namespace MultidocParser\DTO;

use SparkleDto\DataTransferObject;

/**
 * @property mixed $id
 * @property string $name
 * @property CategoryDto[] $categories
 * @property RouteDto[] $routeList
 */
class CategoryDto extends DataTransferObject
{
    protected $casts = [
        'categories' => CategoryDto::class,
        'routeList' => RouteDto::class
    ];

    public function __construct($arguments)
    {
        parent::__construct($arguments);
        $this->routeList = [];
    }

    public function addRoute(RouteDto $route)
    {
        $this->routeList = [...$this->routeList, $route];
    }
}