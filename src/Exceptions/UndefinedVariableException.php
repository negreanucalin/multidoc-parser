<?php

namespace MultidocParser\Exceptions;

class UndefinedVariableException extends \Exception
{
    const MESSAGE = 'Variable not defined: ';

    public function __construct($variable)
    {
        parent::__construct(self::MESSAGE.$variable);
    }
}