<?php

namespace MultidocParser\DTO;

use SparkleDto\DataTransferObject;

/**
 * @property string $url
 * @property string $method
 * @property string $secured
 * @property HeaderDto[]|null $headers
 * @property ParameterDto[]|null $params
 */
class RequestDto extends DataTransferObject
{
    protected $casts = [
        'params' => ParameterDto::class,
        'headers' => HeaderDto::class,
        'secured' => 'boolean'
    ];

    public function jsonSerialize()
    {
        $data = array(
            'url'=>$this->url,
            'method'=>$this->method,
            'needsAuthentication'=>$this->secured
        );
        if($this->headers){
            $data['headers'] = $this->headers;
        }
        if($this->params){
            $data['params'] = $this->params;
        }
        return $data;
    }

}