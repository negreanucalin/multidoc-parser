<?php
/**
 * Created by PhpStorm.
 * User: canegreanu
 * Date: 06-Jun-17
 * Time: 11:18 AM
 */

namespace Multidoc\Renderers;


use Multidoc\Models\Status;

class StatusRenderer
{
    public function renderList($statusCodeList)
    {
        $codeArrayList = array();
        foreach($statusCodeList as $statusCode){
            $codeArrayList[] = $this->renderEntity($statusCode);
        }
        return $codeArrayList;
    }

    private function renderEntity(Status $statusCode)
    {
        $data = array(
            'code'=>$statusCode->getCode(),
            'message'=>$statusCode->getMessage(),
            'description'=>'Not available'
        );
        if($statusCode->getDescription()){
            $data['description'] = $statusCode->getDescription();
        }
        return $data;
    }
}