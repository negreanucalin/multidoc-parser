<?php

namespace MultidocParser\DTO;

use SparkleDTO\DataTransferObject;

/**
 * @property $name string
 * @property $url string
 */
class EnvironmentDto extends DataTransferObject
{
    public function __construct($arguments)
    {
        parent::__construct($arguments);
    }
}