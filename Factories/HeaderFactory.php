<?php
/**
 * Created by PhpStorm.
 * User: canegreanu
 * Date: 07-Jun-17
 * Time: 9:36 AM
 */

namespace Multidoc\Factories;

use Multidoc\Models\Header;

class HeaderFactory
{

    const HEADERS_KEY = 'headers';

    public function buildList($headerArray)
    {
        $headerList = array();
        foreach($headerArray as $headerValue) {
            $headerList[] = $this->buildEntity($headerValue);
        }
        return $headerList;
    }

    private function buildEntity($headerValue)
    {
        $header = new Header();
        $header->setName(key($headerValue));
        $header->setValue(current($headerValue));
        return $header;
    }
}