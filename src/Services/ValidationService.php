<?php

namespace MultidocParser\Services;

use MultidocParser\Exceptions\CategoriesNotFoundException;
use MultidocParser\Exceptions\ProjectNotDefinedException;
use MultidocParser\Exceptions\RoutesNotDefinedException;
use MultidocParser\Exceptions\UndefinedVariableException;
use MultidocParser\Exceptions\UnusedVariableException;

class ValidationService
{
    /**
     * @throws ProjectNotDefinedException
     * @throws RoutesNotDefinedException
     * @throws CategoriesNotFoundException
     */
    public function validateParsedData(array $data)
    {
        if (!isset($data[FileContentParserService::CATEGORY_PLURAL_KEY])) {
            throw new CategoriesNotFoundException();
        }
        if (!isset($data[FileContentParserService::PROJECT_KEY])) {
            throw new ProjectNotDefinedException();
        }
        if (!isset($data[FileContentParserService::ROUTE_PLURAL_KEY])) {
            throw new RoutesNotDefinedException();
        }
    }

    /**
     * @throws UndefinedVariableException
     * @throws UnusedVariableException
     */
    public function validateVariables(array $data)
    {
        if (!isset($data[FileContentParserService::PROJECT_KEY]['variables'])) {
            return;
        }
        foreach ($data[FileContentParserService::PROJECT_KEY]['variables'] as $variableKey => $variable) {
            $this->checkVariableIsInUse($variableKey, $data[FileContentParserService::ROUTE_PLURAL_KEY]);
        }
        foreach ($data[FileContentParserService::ROUTE_PLURAL_KEY] as $route) {
            $this->checkRouteVariables($route, $data[FileContentParserService::PROJECT_KEY]['variables']);
        }
    }

    /**
     * @throws UnusedVariableException
     */
    private function checkVariableIsInUse(string $variableKey, $routeList)
    {
        $variableString = sprintf(FileContentParserService::variableFormat, $variableKey);
        $includesVariable = false;
        foreach ($routeList as $route) {
            if (str_contains($route['request']['url'], $variableString)) {
                $includesVariable = true;
                break;
            }
            if (array_key_exists('headers', $route['request'])) {
                foreach ($route['request']['headers'] as $header) {
                    $headerType = array_keys($header)[0];
                    $headerValue = $header[$headerType];
                    if (str_contains($headerValue, $variableString)) {
                        $includesVariable = true;
                        break;
                    }
                }
            }
        }
        if (!$includesVariable) {
            throw new UnusedVariableException($variableKey);
        }
    }

    /**
     * @throws UndefinedVariableException
     */
    private function checkRouteVariables($route, $variables)
    {
        $routeParameter = $this->getVariableFromString($route['request']['url']);
        if (!empty($routeUrl)) {
            if (!array_key_exists($routeParameter, $variables)) {
                throw new UndefinedVariableException($routeParameter);
            }
        }
        if (isset($route['request']['headers'])) {
            foreach ($route['request']['headers'] as $header) {
                $headerType = array_keys($header)[0];
                $headerValue = $header[$headerType];
                $headerVariable = $this->getVariableFromString($headerValue);
                if (!empty($headerVariable) && !array_key_exists($headerVariable, $variables)) {
                    throw new UndefinedVariableException($headerVariable);
                }
            }
        }
    }

    private function getVariableFromString($str, $start=FileContentParserService::variableStart, $end=FileContentParserService::variableEnd)
    {
        return $this->startsWith($start, $str) && $this->endsWith($end, $str);
    }

    private function startsWith($haystack, $needle)
    {
        return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
    }

    private function endsWith($haystack, $needle)
    {
        return substr_compare($haystack, $needle, -strlen($needle)) === 0;
    }
}