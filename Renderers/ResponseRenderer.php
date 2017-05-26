<?php
/**
 * Created by PhpStorm.
 * User: canegreanu
 * Date: 06-Jun-17
 * Time: 11:18 AM
 */

namespace Multidoc\Renderers;

use Multidoc\Models\Response;


class ResponseRenderer
{

    /**
     * @var HeaderRenderer
     */
    private $headerRenderer;

    public function __construct(HeaderRenderer $headerRenderer)
    {
        $this->headerRenderer = $headerRenderer;
    }


    public function renderEntity(Response $response)
    {
        return array(
            'code'=>$response->getCode(),
            'text'=>$response->getText(),
            'headers'=>$this->headerRenderer->renderList($response->getHeaders())
        );
    }
}