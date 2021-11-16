<?php

namespace Multidoc\Exceptions;

class CategoriesNotFoundException extends \Exception
{
    const MESSAGE = 'Categories are missing from the current configuration';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}