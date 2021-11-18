<?php

namespace MultidocParser\DTO;

use SparkleDto\DataTransferObject;

/**
 * @property string $name
 * @property string $url
 */
class EnvironmentDto extends DataTransferObject
{
    public function __construct($arguments)
    {
        parent::__construct($arguments);
    }
}