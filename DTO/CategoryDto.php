<?php

namespace Multidoc\DTO;

use SparkleDTO\DataTransferObject;

/**
 * @property $id mixed
 * @property $name string
 * @property $categories CategoryDto[]
 * @property $routeList RouteDto[]
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