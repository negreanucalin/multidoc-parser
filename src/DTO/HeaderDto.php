<?php

namespace Multidoc\DTO;

use SparkleDTO\DataTransferObject;

/**
 * @property $name string
 * @property $value string
 */
class HeaderDto extends DataTransferObject
{
    public function __construct($arguments)
    {
        $arguments = ['name' => array_keys($arguments)[0], 'value' => array_values($arguments)[0]];
        parent::__construct($arguments);
    }
}