<?php
/**
 * Created by PhpStorm.
 * User: canegreanu
 * Date: 07-Jun-17
 * Time: 9:35 AM
 */

namespace Multidoc\Models;


class Request
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var boolean
     */
    private $secured;

    /**
     * @var string
     */
    private $method;

    /**
     * @var Parameter[]
     */
    private $parameterList;

    /**
     * @var Header[]
     */
    private $headers;

    /**
     * @return Header[]
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param Header[] $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return Parameter[]
     */
    public function getParameterList()
    {
        return $this->parameterList;
    }

    /**
     * @param Parameter[] $parameterList
     */
    public function setParameterList($parameterList)
    {
        $this->parameterList = $parameterList;
    }

    /**
     * @return bool
     */
    public function isSecured()
    {
        return $this->secured;
    }

    /**
     * @param bool $secured
     */
    public function setSecured($secured)
    {
        $this->secured = $secured;
    }
}