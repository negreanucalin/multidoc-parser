<?php

namespace MultidocParser\Exceptions;

class NoCategoryRouteException extends \Exception
{
    const MESSAGE = 'Missing category for route:';

    public function __construct($name)
    {
        parent::__construct(self::MESSAGE.' '. $name);
    }
}