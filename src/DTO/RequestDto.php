<?php

namespace Multidoc\DTO;

use SparkleDTO\DataTransferObject;

/**
 * @property $url string
 * @property $method string
 * @property $secured string
 * @property $headers HeaderDto[]|null
 * @property $params ParameterDto[]|null
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