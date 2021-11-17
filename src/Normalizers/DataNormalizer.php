<?php

namespace Multidoc\Normalizers;

use Multidoc\Exceptions\UndefinedTemplateException;
use Multidoc\Services\FileContentParserService;
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
     */
    public function formatTagsAndStatusAndHeaders($routeDefinitionList)
    {
        foreach ($routeDefinitionList as $routeIndex => $routeDefinition) {
            if (isset($routeDefinition['request']) && isset($routeDefinition['request']['headers'])) {
                $headers = [];
                foreach ($routeDefinition['request']['headers'] as $index => $header) {
                    $headers[] = [$index => $header];
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

        foreach($routeDefinitionList as $routeIndex => $routeDefinition) {
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
            if (!isset($headerTemplate[0]) || !is_string($headerTemplate[0])) {// Header is defined as map
                continue;
            }
            $templateName = $headerTemplate[0];
            if (!isset($templates['headers'][$templateName])) {
                throw new UndefinedTemplateException($templateName);
            }
            $templatesToFill[] = $templateName;
            unset($routeArray['request']['headers'][$index]);

        }
        foreach($templatesToFill as $template) {
            $routeArray['request']['headers'] = array_merge_recursive(
                $routeArray['request']['headers'],
                $templates['headers'][$template]
            );
        }
        return $routeArray;
    }

    public function normalizeProjectData($projectDefinition)
    {
        $projectDefinition['buildDate'] = (new \DateTime())->format('U');
        if (isset($projectDefinition['environments'])) {
            $projectDefinition['environments'] = $this->formatEnvironments($projectDefinition['environments']);
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

    private function formatEnvironments($environmentList)
    {
        if (empty($environmentList['environments'])) {
            return null;
        }
        $list = [];
        foreach ($environmentList['environments'] as $name => $link) {
            $list[] = [
                'name' => $name,
                'url' => $link
            ];
        }
        return $list;
    }
}