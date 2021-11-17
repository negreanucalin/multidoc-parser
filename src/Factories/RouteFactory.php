<?php

namespace Multidoc\Factories;

use Multidoc\DTO\RouteDto;
use Multidoc\Exceptions\UndefinedTemplateException;

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

    public function buildRouteListFromArray($templates, $routeListArray)
    {
        $routeList = array();
        foreach ($routeListArray as $routeArray) {
            $routeArray = $this->fillInTemplates($templates, $routeArray);
            $routeList[] = $this->buildRouteFromArray($routeArray);
        }
        return $routeList;
    }

    /**
     * @throws UndefinedTemplateException
     */
    private function fillInTemplates($templates, $routeArray)
    {
        if (empty($templates)) {
            return $routeArray;
        }
        $routeArray = $this->parseParameters($templates, $routeArray);
        return $this->parseHeaders($templates, $routeArray);
    }

    /**
     * @throws UndefinedTemplateException
     */
    private function parseParameters($templates, $routeArray)
    {
        if (!isset($routeArray['request']['params'])) {
            return $routeArray;
        }
        $templatesToFill = [];
        foreach ($routeArray['request']['params'] as $index => $paramDefined) {
            if (!isset($paramDefined['name'])) { // template
                if (!isset($templates['params'][$paramDefined])) {
                    throw new UndefinedTemplateException($paramDefined);
                }
                $templatesToFill[] = $paramDefined;
                unset($routeArray['request']['params'][$index]);
            }
        }
        foreach($templatesToFill as $template) {
            $routeArray['request']['params'] = array_merge_recursive(
                $routeArray['request']['params'],
                $templates['params'][$template]
            );
        }
        return $routeArray;
    }

    /**
     * @throws UndefinedTemplateException
     */
    private function parseHeaders($templates, $routeArray)
    {
        if (!isset($routeArray['request']['headers'])) {
            return $routeArray;
        }
        $templatesToFill = [];
        foreach ($routeArray['request']['headers'] as $index => $headerTemplate) {
            if (is_array($headerTemplate)) {
                continue;
            }
            if (is_numeric($index)) { // template
                if (!isset($templates['headers'][$headerTemplate])) {
                    throw new UndefinedTemplateException($headerTemplate);
                }
                $templatesToFill[] = $headerTemplate;
                unset($routeArray['request']['headers'][$index]);
            }
        }
        foreach($templatesToFill as $template) {
            $routeArray['request']['headers'] = array_merge_recursive(
                $routeArray['request']['headers'],
                $templates['headers'][$template]
            );
        }
        return $routeArray;
    }

}