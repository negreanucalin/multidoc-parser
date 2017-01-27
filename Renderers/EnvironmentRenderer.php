<?php

namespace Multidoc\Renderers;

use Multidoc\Models\Environment;

class EnvironmentRenderer
{

    public function renderEnvironmentList($environmentList)
    {
        $list = array();
        foreach($environmentList as $environment) {
            $list[]=$this->renderEnvironment($environment);
        }
        return $list;
    }

    public function renderEnvironment(Environment $environment)
    {
        return array(
            'name'=>$environment->getName(),
            'url'=>$environment->getUrl()
        );
    }
}