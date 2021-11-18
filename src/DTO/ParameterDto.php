<?php

namespace MultidocParser\DTO;

use SparkleDto\DataTransferObject;

/**
 * @property string $type
 * @property string $name
 * @property string $example
 * @property string $data_type
 * @property string $description
 * @property boolean $optional
 * @property string $default
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
        if ($this->default) {
            $data['default'] = $this->default;
        }
        return $data;
    }
}