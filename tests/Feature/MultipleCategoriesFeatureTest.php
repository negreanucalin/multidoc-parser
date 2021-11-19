<?php

namespace MultidocParser\Tests\Feature;

use MultidocParser\Tests\MultidocParserTestFeature;

class MultipleCategoriesFeatureTest extends MultidocParserTestFeature
{
    protected string $dataPath = __DIR__.'/../data_in/multiple_categories';
    protected string $outPath = __DIR__.'/../data_out/multiple_categories';

    public function test_categories_exist()
    {
        $this->assertProjectHasCategory('Forth level', $this->project);
    }
}