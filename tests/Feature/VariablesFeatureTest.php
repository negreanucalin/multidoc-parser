<?php

namespace MultidocParser\Tests\Feature;

use MultidocParser\Tests\MultidocParserTestFeature;

class VariablesFeatureTest extends MultidocParserTestFeature
{
    protected string $dataPath = __DIR__.'/../data_in/variables';
    protected string $outPath = __DIR__.'/../data_out/variables';

    public function test_basic_template_exist()
    {
         $this->assertRouteHasParameterName('userId','User retrieval', $this->project);
         $this->assertRouteHasHeaders(['Accept'=>'application/json'], 'User deletion', $this->project);
         $this->assertRouteHasHeaders(['Authorization'=>'Bearer APPLICATION_TOKEN'], 'User deletion', $this->project);
         $this->assertHasVariables($this->project);
         $this->assertHasVariable('OTHER_TOKEN', $this->project);
    }
}