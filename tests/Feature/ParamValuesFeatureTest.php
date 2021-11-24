<?php

namespace MultidocParser\Tests\Feature;

use MultidocParser\Tests\MultidocParserTestFeature;

class ParamValuesFeatureTest extends MultidocParserTestFeature
{
    protected string $dataPath = __DIR__.'/../data_in/param_values';
    protected string $outPath = __DIR__.'/../data_out/param_values';

    public function test_basic_template_exist()
    {
         $this->assertRouteHasParameterName('type','User authentication', $this->project);
    }
}