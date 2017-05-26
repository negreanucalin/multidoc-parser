<?php
/**
 * Created by PhpStorm.
 * User: canegreanu
 * Date: 06-Jun-17
 * Time: 2:02 PM
 */

namespace Multidoc\Factories;


use Multidoc\Models\Response;

class ResponseFactory
{
    /**
     * @var HeaderFactory
     */
    private $headerFactory;

    public function __construct(
        HeaderFactory $headerFactory
    ) {
        $this->headerFactory = $headerFactory;
    }

    public function buildEntity($responseArr)
    {
        $response = new Response();
        $response->setCode($responseArr['code']);
        $response->setText($responseArr['text']);
        if(array_key_exists(HeaderFactory::HEADERS_KEY, $responseArr)){
            $response->setHeaders($this->headerFactory->buildList($responseArr[HeaderFactory::HEADERS_KEY]));
        }
        return $response;
    }
}