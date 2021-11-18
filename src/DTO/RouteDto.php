<?php

namespace MultidocParser\DTO;

use SparkleDto\DataTransferObjectWithId;

/**
 * @property mixed $id
 * @property string $name
 * @property string $description
 * @property mixed $categoryId
 * @property TagDto[] $tagList
 * @property string $inputPath
 * @property CategoryDto|null $category
 * @property StatusDto[] $statusList
 * @property ResponseDto|null $response
 * @property RequestDto|null $request
 */
class RouteDto extends DataTransferObjectWithId
{
    protected $casts = [
        'tagList' => TagDto::class,
        'statusList' => StatusDto::class,
        'response' => ResponseDto::class,
        'category' => CategoryDto::class,
        'request' => RequestDto::class
    ];

    protected $alias = [
        'definitionFile'=>'inputPath'
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