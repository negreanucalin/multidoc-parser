<?php

namespace MultidocParser\Tests\Feature;

use MultidocParser\Tests\MultidocParserTestFeature;

class TemplatesFeatureTest extends MultidocParserTestFeature
{
    protected string $dataPath = __DIR__.'/../data_in/templates';
    protected string $outPath = __DIR__.'/../data_out/templates';

    public function test_basic_template_exist()
    {
         $this->assertRouteHasParameterName('userId','User retrieval 1', $this->project);
         $this->assertRouteHasHeaders(['Accept'=>'application/json'], 'User retrieval 1', $this->project);
    }
}