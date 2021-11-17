<?php

namespace MultidocParser\DTO;

use SparkleDto\DataTransferObject;

/**
 * @property $code string
 * @property $text string
 * @property $headers HeaderDto[]
 */
class ResponseDto extends DataTransferObject
{
    protected $casts = [
        'headers' => HeaderDto::class
    ];
}