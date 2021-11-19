<?php

namespace MultidocParser\Tests\Feature;

use MultidocParser\Tests\MultidocParserTestFeature;

class BasicMinimizedFeatureTest extends MultidocParserTestFeature
{
    protected string $dataPath = __DIR__.'/../data_in/basic_minimized';
    protected string $outPath = __DIR__.'/../data_out/basic_minimized';

    public function test_basic_minimized_exist()
    {
        $this->assertEquals('My Awesome project minimized', $this->project->name);
        $this->assertEquals('1', $this->project->version);
        $this->assertEquals('My Awesome project basic minimized description', $this->project->description);
    }
}