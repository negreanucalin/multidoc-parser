<?php

namespace Multidoc\DTO;

use SparkleDTO\DataTransferObject;

/**
 * @property $id mixed
 * @property $name string
 * @property $description string
 * @property $categoryId mixed
 * @property $tagList TagDto[]
 * @property $inputPath string
 * @property $category CategoryDto|null
 * @property $statusList StatusDto[]
 * @property $response ResponseDto|null
 * @property $request RequestDto|null
 */
class RouteDto extends DataTransferObject
{
    protected $casts = [
        'tagList' => TagDto::class,
        'statusList' => StatusDto::class,
        'response' => ResponseDto::class,
        'category' => CategoryDto::class,
        'request' => RequestDto::class
    ];

    public function jsonSerialize()
    {
        $data = array(
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description
        );
        if($this->statusList){
            $data['statusCodes'] = $this->statusList;
        }
        if($this->response){
            $data['response'] = $this->response;
        }
        if($this->request){
            $data['request'] = $this->request;
        }
        if($this->tagList){
            $data['tags'] = $this->tagList;
        }
        return $data;
    }
}