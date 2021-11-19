<?php

namespace MultidocParser\Tests\Feature;

use MultidocParser\Tests\MultidocParserTestFeature;

class ProjectLogoFeatureTest extends MultidocParserTestFeature
{
    protected string $dataPath = __DIR__.'/../data_in/project_logo';
    protected string $outPath = __DIR__.'/../data_out/project_logo';

    public function test_basic_logo_exist()
    {
        $this->assertNotEmpty($this->project->logo);
    }
}