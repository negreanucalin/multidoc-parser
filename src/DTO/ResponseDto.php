<?php

namespace MultidocParser\DTO;

use SparkleDto\DataTransferObject;

/**
 * @property string $code
 * @property string $text
 * @property HeaderDto[] $headers
 */
class ResponseDto extends DataTransferObject
{
    protected $casts = [
        'headers' => HeaderDto::class
    ];
}