<?php

namespace MultidocParser\Tests\Feature;

use MultidocParser\Exceptions\UnusedVariableException;
use MultidocParser\Tests\MultidocParserTestFeature;

class VariablesFeatureTest extends MultidocParserTestFeature
{
    protected string $dataPath = __DIR__.'/../data_in/variables';
    protected string $outPath = __DIR__.'/../data_out/variables';
    protected array $excludeList =[
        __DIR__.'/../data_in/variables/variation/unused_variable/categories.yml',
        __DIR__.'/../data_in/variables/variation/unused_variable/project.yml',
        __DIR__.'/../data_in/variables/variation/unused_variable/routes.yml',
    ];

    public function test_basic_template_exist()
    {
         $this->assertRouteHasParameterName('userId','User retrieval', $this->project);
         $this->assertRouteHasHeaders(['Accept'=>'application/json'], 'User deletion', $this->project);
         $this->assertRouteHasHeaders(['Authorization'=>'Bearer {{APPLICATION_TOKEN}}'], 'User deletion', $this->project);
         $this->assertHasVariables($this->project);
         $this->assertHasVariable('environment', $this->project);
    }

    public function test_unused_variable_variation()
    {
        $this->expectException(UnusedVariableException::class);
        $this->project = $this->parser->generate(
            __DIR__.'/../data_in/variables/variation/unused_variable',
            __DIR__.'/../data_out/variables/variation/unused_variable'
        );
    }
}