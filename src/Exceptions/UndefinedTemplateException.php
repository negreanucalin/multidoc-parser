<?php

namespace Multidoc\Exceptions;

use Exception;

class UndefinedTemplateException extends Exception
{
    const MESSAGE = 'Missing template definition for: ';

    public function __construct($template)
    {
        parent::__construct(self::MESSAGE . $template);
    }
}