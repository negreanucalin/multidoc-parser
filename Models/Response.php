<?php

namespace Multidoc\Models;

class Response
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var int
     */
    private $code;

    /**
     * @var array
     */
    private $headerList;

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headerList;
    }

    /**
     * @param array $headerList
     */
    public function setHeaders($headerList)
    {
        $this->headerList = $headerList;
    }
}