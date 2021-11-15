<?php

namespace Multidoc\Factories;
use Multidoc\Models\Parameter;

class ParameterFactory
{
    const PARAMETER_TYPE_FILE = 'file';

    const PARAMETER_PLURAL_KEY = 'params';

    public function __construct()
    {

    }

    /**
     * @param $parameterArray
     * @return Parameter
     */
    public function buildParameterFromArray($parameterArray)
    {
        $parameter = new Parameter();
        if(isset($parameterArray['name'])){
            $parameter->setName($parameterArray['name']);
        }
        if (isset($parameterArray['description'])) {
            $parameter->setDescription($parameterArray['description']);
        }
        $parameter->setType(strtolower($parameterArray['type']));
        $parameter->setDataType($parameterArray['data_type']);
        if (isset($parameterArray['example'])) {
            $parameter->setExample($parameterArray['example']);
        }
        $parameter->setIsOptional(false);
        if(isset($parameterArray['optional'])){
            $parameter->setIsOptional((boolean)$parameterArray['optional']);
        }
        return $parameter;
    }

    public function buildParameterListFromArray($parameterListArray)
    {
        $environmentList = array();
        foreach ($parameterListArray as $parameterArray){
            $environmentList[]=$this->buildParameterFromArray($parameterArray);
        }
        return $environmentList;
    }

}