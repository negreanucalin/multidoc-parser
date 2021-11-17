<?php
namespace Multidoc\Renderers;

use Multidoc\DTO\CategoryDto;

class CategoryRenderer
{
    /**
     * @param CategoryDto[] $categoryList
     * @return array
     */
    public function renderList($categoryList)
    {
        $list = array();
        foreach ($categoryList as $category) {
            $list['children'][] = $this->renderEntity($category);
        }
        return $list;
    }

    /**
     * @param CategoryDto $category
     * @return array
     */
    public function renderEntity(CategoryDto $category)
    {
        $children = [];
        $data = array(
            'id' => $category->id,
            'name' => $category->name
        );

        if ($category->categories) {
            $renderedList = $this->renderList($category->categories);
            $children = array_pop($renderedList);
        }
        if ($category->routeList) {
            $children = array_merge($children, $category->routeList);
        }

        $data['children'] = $children;
        return $data;
    }
}