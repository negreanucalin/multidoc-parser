<?php

namespace MultidocParser\Tests\Feature;

use MultidocParser\Tests\MultidocParserTestFeature;

class FilesFeatureTest extends MultidocParserTestFeature
{
    protected string $dataPath = __DIR__.'/../data_in/files';
    protected string $outPath = __DIR__.'/../data_out/files';

    public function test_basic_minimized_exist()
    {
        $this->assertEquals('My Awesome project', $this->project->name);
        $this->assertEquals('1', $this->project->version);
        $this->assertEquals('My Awesome project', $this->project->description);
    }
}