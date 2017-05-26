<?php
/**
 * Created by PhpStorm.
 * User: canegreanu
 * Date: 06-Jun-17
 * Time: 11:18 AM
 */

namespace Multidoc\Renderers;

use Multidoc\Models\Request;


class RequestRenderer
{
    /**
     * @var ParameterRenderer
     */
    private $paramRenderer;

    /**
     * @var HeaderRenderer
     */
    private $headerRenderer;

    public function __construct(
        HeaderRenderer $headerRenderer,
        ParameterRenderer $paramRenderer
    ) {
        $this->headerRenderer = $headerRenderer;
        $this->paramRenderer = $paramRenderer;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function renderEntity(Request $request)
    {
        $data = array(
            'url'=>$request->getUrl(),
            'method'=>$request->getMethod(),
            'needsAuthentication'=>$request->isSecured()
        );
        if($request->getHeaders()){
            $data['headers'] = $this->headerRenderer->renderList($request->getHeaders());
        }
        if($request->getParameterList()){
            $data['params'] = $this->paramRenderer->renderList($request->getParameterList());
        }
        return $data;
    }
}