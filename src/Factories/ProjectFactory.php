<?php

namespace Multidoc\Factories;

use Multidoc\DTO\CategoryDto;
use Multidoc\DTO\ProjectDto;

class ProjectFactory
{
    /**
     * @param $projectArray
     * @return ProjectDto
     */
    public function buildProjectFromArray($projectArray, $categoryList)
    {
        $projectArray['categories'] = CategoryDto::hydrate($categoryList);
        return new ProjectDto($projectArray);
    }

}