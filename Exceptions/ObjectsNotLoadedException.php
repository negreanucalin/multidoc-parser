<?php
/**
 * Created by PhpStorm.
 * User: canegreanu
 * Date: 1/30/2017
 * Time: 10:43 AM
 */

namespace Multidoc\Exceptions;


class ObjectsNotLoadedException extends \Exception
{
    const MESSAGE = 'Please run the method: %s first';

    public function __construct($methodName)
    {
        parent::__construct(sprintf(self::MESSAGE, $methodName));
    }
}