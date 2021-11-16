<?php

namespace Multidoc\Factories;

use Multidoc\DTO\CategoryDto;
use Multidoc\DTO\ProjectDto;

class ProjectFactory
{
    const LOGO_KEY = 'logo';
    const PROJECT_KEY = 'project';

    const FILE_PATH_KEY = 'definitionFile';

    /**
     * @param $projectArray
     * @return ProjectDto
     */
    public function buildProjectFromArray($projectArray, $categoryList)
    {
        $categoryList = $this->formatCategories($categoryList);
        $projectArray['buildDate'] = (new \DateTime())->format('U');
        $projectArray['categories'] = CategoryDto::hydrate($categoryList);
        $projectArray['environments'] = $this->formatEnvironments($projectArray);
        return new ProjectDto($projectArray);
    }

    private function formatCategories($categoryList)
    {
        $newCatList = [];
        foreach ($categoryList as $index=>$category) {
            $categories = null;
            if (isset($category['categories']) && is_array($category['categories'])) {
                $categories = $this->formatCategories($category['categories']);
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