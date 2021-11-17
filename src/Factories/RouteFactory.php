<?php

namespace Multidoc\Factories;

use Multidoc\DTO\RouteDto;

class RouteFactory
{

    const ROUTE_METHOD_POST = 'POST';
    const ROUTE_SINGULAR_KEY = 'route';
    const ROUTE_PLURAL_KEY = 'route_list';
    const FILE_PATH_KEY = 'definitionFile';

    /**
     * @param $routeArray
     * @return RouteDto
     */
    public function buildRouteFromArray($routeArray)
    {
        $routData = [
            'name' => $routeArray['name'],
            'description' => $routeArray['description'],
            'categoryId' => $routeArray['category'],
        ];
        if (array_key_exists(AbstractFactory::TAGS_KEY, $routeArray)) {
            foreach ($routeArray[AbstractFactory::TAGS_KEY] as $tag) {
                $routData['tagList'][] = ['name' => $tag];
            }
        }
        if (array_key_exists(AbstractFactory::STATUS_PLURAL_LIST, $routeArray)) {
            foreach ($routeArray[AbstractFactory::STATUS_PLURAL_LIST] as $status) {
                $routData['statusList'][] = ['name' => $status];
            }
        }
        if (array_key_exists('response', $routeArray)) {
            $routData['response'] = $routeArray['response'];
        }
        if (array_key_exists('request', $routeArray)) {
            $routData['request'] = $routeArray['request'];
        }
        $routData['inputPath'] = $routeArray[self::FILE_PATH_KEY];
        return new RouteDto($routData);
    }

    public function buildRouteListFromArray($routeListArray)
    {
        $routeList = array();
        foreach ($routeListArray as $routeArray) {
            $routeList[] = $this->buildRouteFromArray($routeArray);
        }
        return $routeList;
    }

}