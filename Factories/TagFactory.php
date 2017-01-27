<?php
/**
 * Created by PhpStorm.
 * User: canegreanu
 * Date: 1/27/2017
 * Time: 10:48 AM
 */

namespace Multidoc\Factories;


use Multidoc\Models\Tag;

class TagFactory
{

    public function buildTagFromArray($tagArray)
    {
        $tag = new Tag();
        $tag->setName($tagArray);
        return $tag;
    }

    public function buildTagListFromArray($tagListArray)
    {
        $list = array();
        foreach($tagListArray as $tagArray){
            $list[]=$this->buildTagFromArray($tagArray);
        }
        return $list;
    }
}