<?php
/**
 * Created by PhpStorm.
 * User: canegreanu
 * Date: 1/27/2017
 * Time: 10:55 AM
 */

namespace Multidoc\Renderers;


use Multidoc\Models\Parameter;

class ParameterRenderer
{

    /**
     * @param Parameter[] $parameterList
     * @return array
     */
    public function renderList($parameterList)
    {
        $list = array();
        foreach($parameterList as $parameter){
            $list[]=$this->renderEntity($parameter);
        }
        return $list;
    }

    /**
     * @param Parameter $parameter
     * @return array
     */
    public function renderEntity(Parameter $parameter)
    {
        $data = array(
            'type'=>$parameter->getType(),
            'example'=>$parameter->getExample(),
            'data_type'=>$parameter->getDataType(),
            'description'=>$parameter->getDescription(),
            'isOptional'=>$parameter->isIsOptional(),
        );
        if($parameter->getName()){
            $data['name']=$parameter->getName();
        }
        return $data;
    }

}