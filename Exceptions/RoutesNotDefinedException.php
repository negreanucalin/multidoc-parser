<?php

namespace Multidoc\Exceptions;

class RoutesNotDefinedException extends \Exception
{
    const MESSAGE = 'Routes are missing from the current configuration';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}