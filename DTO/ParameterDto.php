<?php

namespace Multidoc\DTO;

use SparkleDTO\DataTransferObject;

/**
 * @property $type string
 * @property $name string
 * @property $example string
 * @property $data_type string
 * @property $description string
 * @property $optional boolean
 */
class ParameterDto extends DataTransferObject
{
    protected $casts = [
        'optional' => 'boolean'
    ];

    public function jsonSerialize()
    {
        $data = [
            'type'=>$this->type,
            'example'=>$this->example,
            'data_type'=>$this->data_type,
            'description'=>$this->description,
            'isOptional'=>$this->optional,
        ];
        if ($this->name) {
            $data['name'] = $this->name;
        }
        return $data;
    }
}