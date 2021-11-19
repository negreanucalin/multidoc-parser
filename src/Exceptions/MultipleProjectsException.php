<?php

namespace MultidocParser\Exceptions;

use Exception;

class MultipleProjectsException extends Exception
{
    const MESSAGE = 'Multiple projects detected, file:';

    public function __construct(array $files)
    {
        parent::__construct(self::MESSAGE.implode(', ',$files));
    }
}