<?php

namespace Multidoc\DTO;

use SparkleDTO\DataTransferObject;

/**
 * @property $name string
 */
class TagDto extends DataTransferObject
{
    public function jsonSerialize()
    {
        return $this->name;
    }
}