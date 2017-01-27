<?php
/**
 * Created by PhpStorm.
 * User: canegreanu
 * Date: 1/27/2017
 * Time: 10:47 AM
 */

namespace Multidoc\Models;


class Tag
{
    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
