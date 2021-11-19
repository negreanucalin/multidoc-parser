<?php

namespace MultidocParser\Tests\Feature;

use MultidocParser\Tests\MultidocParserTestFeature;

class PostJSONFeatureTest extends MultidocParserTestFeature
{
    protected string $dataPath = __DIR__.'/../data_in/post_json';
    protected string $outPath = __DIR__.'/../data_out/post_json';

    public function test_basic_post_json_exist()
    {
        $this->assertRouteHasParameterType(
            'json',
            'credentials',
            'User authentication',
            $this->project
        );
    }
}