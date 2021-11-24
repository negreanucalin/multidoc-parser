<?php

namespace MultidocParser\Exceptions;

class UnusedVariableException extends \Exception
{
    const MESSAGE = 'Variable not use: ';

    public function __construct($variable)
    {
        parent::__construct(self::MESSAGE.$variable);
    }
}