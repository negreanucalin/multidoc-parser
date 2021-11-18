<?php

namespace MultidocParser\DTO;

use SparkleDto\DataTransferObject;

/**
 * @property string $name
 */
class TagDto extends DataTransferObject
{
    public function jsonSerialize()
    {
        return $this->name;
    }
}