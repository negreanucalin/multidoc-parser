<?php
/**
 * Created by PhpStorm.
 * User: canegreanu
 * Date: 07-Jun-17
 * Time: 9:44 AM
 */

namespace Multidoc\Renderers;


use Multidoc\Models\Header;

class HeaderRenderer
{
    /**
     * @param Header[] $headerList
     * @return array
     */
    public function renderList($headerList)
    {
        $list = array();
        foreach($headerList as $header){
            $list[]=$this->renderEntity($header);
        }
        return $list;
    }

    /**
     * @param Header $header
     * @return array
     */
    public function renderEntity(Header $header)
    {
        return array(
            'name'=>$header->getName(),
            'value'=>$header->getValue()
        );
    }
}