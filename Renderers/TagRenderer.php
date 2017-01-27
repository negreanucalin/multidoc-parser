<?php
/**
 * Created by PhpStorm.
 * User: canegreanu
 * Date: 1/27/2017
 * Time: 10:58 AM
 */

namespace Multidoc\Renderers;


use Multidoc\Models\Tag;

class TagRenderer
{

    /**
     * @param Tag[] $tagList
     * @return array
     */
    public function renderList($tagList)
    {
        $list = array();
        foreach($tagList as $tag){
            $list[]=$this->renderEntity($tag);
        }
        return $list;
    }

    /**
     * @param Tag $tag
     * @return array
     */
    public function renderEntity(Tag $tag)
    {
        return $tag->getName();
    }

}