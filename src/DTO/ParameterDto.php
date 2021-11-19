<?php

namespace MultidocParser\DTO;

use SparkleDto\DataTransferObject;

/**
 * @property string $type
 * @property string $name
 * @property string $example
 * @property string $data_type
 * @property string $description
 * @property boolean $isOptional
 * @property string $default
 */
class ParameterDto extends DataTransferObject
{
    protected $alias = ['optional' => 'isOptional'];

    protected $casts = [
        'isOptional' => 'boolean'
    ];

    public function jsonSerialize()
    {
        $data = [
            'type' => $this->type,
            'example' => $this->example,
            'data_type' => $this->data_type,
            'description' => $this->description,
            'isOptional' => $this->isOptional,
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