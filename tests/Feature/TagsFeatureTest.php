<?php

namespace MultidocParser\Tests\Feature;

use MultidocParser\Tests\MultidocParserTestFeature;

class TagsFeatureTest extends MultidocParserTestFeature
{
    protected string $dataPath = __DIR__.'/../data_in/tags';
    protected string $outPath = __DIR__.'/../data_out/tags';

    public function test_basic_tags_exist()
    {
        $this->assertRouteHasTagsCount(2, 'User partial update', $this->project);
        $this->assertRouteHasTags(['users', 'update'], 'User partial update', $this->project);
    }
}