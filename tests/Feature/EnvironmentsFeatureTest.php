<?php

namespace MultidocParser\Tests\Feature;

use MultidocParser\Tests\MultidocParserTestFeature;

class EnvironmentsFeatureTest extends MultidocParserTestFeature
{
    protected string $dataPath = __DIR__.'/../data_in/environments';
    protected string $outPath = __DIR__.'/../data_out/environments';

    public function test_basic_minimized_exist()
    {
        $this->assertEquals('My Awesome project with environments', $this->project->name);
        $this->assertEquals('1', $this->project->version);
        $this->assertEquals('My Awesome project description with environments', $this->project->description);
    }
}