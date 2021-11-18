<?php

namespace MultidocParser\Normalizers;

use MultidocParser\Exceptions\NoCategoryRouteException;
use MultidocParser\Exceptions\UndefinedTemplateException;
use MultidocParser\Services\FileContentParserService;
use Symfony\Component\Finder\SplFileInfo;

class DataNormalizer
{
    /**
     * This method adds a file path to the given route list in order to keep track of files
     * which it might use for POST requests
     *
     * @param array $routeDefinitionList
     * @param SplFileInfo $file
     * @return array
     */
    public function hydrateFilesToRouteDefinitionList(SplFileInfo $file, $routeDefinitionList)
    {
        foreach ($routeDefinitionList[FileContentParserService::ROUTE_PLURAL_KEY] as $key => $routeDefinition) {
            $routeDefinitionList[FileContentParserService::ROUTE_PLURAL_KEY][$key][FileContentParserService::FILE_PATH_KEY] = $file->getPath();
        }
        return $routeDefinitionList;
    }

    /**
     * @param array[] $routeDefinitionList
     * @return array[]
     * @throws NoCategoryRouteException
     */
    public function formatTagsAndStatusAndHeaders($routeDefinitionList)
    {
        foreach ($routeDefinitionList as $routeIndex => $routeDefinition) {
            if (isset($routeDefinition['request']) && isset($routeDefinition['request']['headers'])) {
                $headers = [];
                foreach ($routeDefinition['request']['headers'] as $index => $header) {
                    $headers[] = [
                        'name'=>array_keys($header)[0],
                        'value'=>array_values($header)[0]
                    ];
                }
                $routeDefinitionList[$routeIndex]['request']['headers'] = $headers;
            }
            if (array_key_exists(FileContentParserService::TAGS_KEY, $routeDefinition)) {
                $routeDefinitionList[$routeIndex]['tagList'] = [];
                foreach ($routeDefinition[FileContentParserService::TAGS_KEY] as $tag) {
                    $routeDefinitionList[$routeIndex]['tagList'][] = ['name' => $tag];
                }
                unset($routeDefinitionList[$routeIndex][FileContentParserService::TAGS_KEY]);
            }
            if (array_key_exists(FileContentParserService::STATUS_PLURAL_LIST, $routeDefinition)) {
                $routeDefinitionList[$routeIndex]['statusList'] = [];
                foreach ($routeDefinition[FileContentParserService::STATUS_PLURAL_LIST] as $status) {
                    $routeDefinitionList[$routeIndex]['statusList'][] = ['name' => $status];
                }
                unset($routeDefinitionList[$routeIndex][FileContentParserService::STATUS_PLURAL_LIST]);
            }
            if (!isset($routeDefinitionList[$routeIndex]['category'])) {
                throw new NoCategoryRouteException($routeDefinitionList[$routeIndex]['name']);
            }
            $routeDefinitionList[$routeIndex]['categoryId'] = $routeDefinitionList[$routeIndex]['category'];
            unset($routeDefinitionList[$routeIndex]['category']);
        }
        return $routeDefinitionList;
    }


    /**
     * @throws UndefinedTemplateException
     */
    public function fillInTemplates($templates, $routeDefinitionList)
    {
        if (empty($templates)) {
            return $routeDefinitionList;
        }

        foreach ($routeDefinitionList as $routeIndex => $routeDefinition) {
            $routeDefinitionList[$routeIndex] = $this->parseParameters($templates, $routeDefinition);
            $routeDefinitionList[$routeIndex] = $this->parseHeaders($templates, $routeDefinitionList[$routeIndex]);
        }

        return $routeDefinitionList;
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
            if (isset($paramDefined['name'])) { // template
                continue;
            }
            if (!isset($templates['params'][$paramDefined])) {
                throw new UndefinedTemplateException($paramDefined);
            }
            $templatesToFill[] = $paramDefined;
            unset($routeArray['request']['params'][$index]);
        }
        foreach($templatesToFill as $template) {
            $routeArray['request']['params'] = array_merge_recursive(
                $templates['params'][$template],
                $routeArray['request']['params']
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
            if (!is_string($headerTemplate)) {// Header is defined as map
                continue;
            }
            if (!isset($templates['headers'][$headerTemplate])) {
                throw new UndefinedTemplateException($headerTemplate);
            }
            $templatesToFill[] = $headerTemplate;
            unset($routeArray['request']['headers'][$index]);
        }
        foreach($templatesToFill as $template) {
            $routeArray['request']['headers'] = array_merge_recursive(
                $templates['headers'][$template],
                $routeArray['request']['headers']
            );
        }
        return $routeArray;
    }

    public function normalizeProjectData($projectDefinition)
    {
        $projectDefinition['buildDate'] = (new \DateTime())->format('U');
        if (isset($projectDefinition['environments'])) {
            $projectDefinition['environments'] = $this->normalizeEnvironments($projectDefinition);
        }
        return $projectDefinition;
    }

    public function normalizeCategoryList($categoryList)
    {
        $newCatList = [];
        foreach ($categoryList as $index=>$category) {
            $categories = null;
            if (isset($category['categories']) && is_array($category['categories'])) {
                $categories = $this->normalizeCategoryList($category['categories']);
            }
            if ($categories) {
                $newCatList[] = ['id'=>$index,'name'=>$category['name'],'categories'=>$categories];
            } else {
                $newCatList[] = ['id'=>$index,'name'=>$category['name']];
            }
        }
        return $newCatList;
    }

    private function normalizeEnvironments($projectDefinition)
    {
        if (!isset($projectDefinition['environments'])) {
            return null;
        }
        $list = [];
        foreach ($projectDefinition['environments'] as $name => $link) {
            $list[] = [
                'name' => $name,
                'url' => $link
            ];
        }
        return $list;
    }
}