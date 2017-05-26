<?php
/**
 * Created by PhpStorm.
 * User: canegreanu
 * Date: 07-Jun-17
 * Time: 9:55 AM
 */

namespace Multidoc\Factories;

use Multidoc\Models\Request;

class RequestFactory
{
    /**
     * @var HeaderFactory
     */
    private $headerFactory;

    /**
     * @var ParameterFactory
     */
    private $parameterFactory;

    const AUTHORIZATION_KEY = 'secured';

    public function __construct(
        HeaderFactory $headerFactory,
        ParameterFactory $paramFactory
    ) {
        $this->headerFactory = $headerFactory;
        $this->parameterFactory = $paramFactory;
    }

    public function buildEntity($requestArray)
    {
        $request = new Request();
        if(array_key_exists(HeaderFactory::HEADERS_KEY, $requestArray)){
            $request->setHeaders($this->headerFactory->buildList($requestArray[HeaderFactory::HEADERS_KEY]));
        }
        $request->setMethod(strtoupper($requestArray['method']));
        $request->setUrl($requestArray['url']);
        $request->setSecured(false);
        if(array_key_exists(self::AUTHORIZATION_KEY, $requestArray)){
            $request->setSecured($requestArray['secured']);
        }
        if(array_key_exists(ParameterFactory::PARAMETER_PLURAL_KEY, $requestArray)){
            $request->setParameterList(
                $this->parameterFactory->buildParameterListFromArray(
                    $requestArray[ParameterFactory::PARAMETER_PLURAL_KEY]
                )
            );
        }
        return $request;
    }
}