<?php

namespace MultidocParser\Exceptions;

class ProjectNotDefinedException extends \Exception
{
    const MESSAGE = 'Project definition is missing from the current configuration';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}