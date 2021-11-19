<?php

namespace MultidocParser\Tests\Feature;

use MultidocParser\Tests\MultidocParserTestFeature;

class AuthorizationFeatureTest extends MultidocParserTestFeature
{
    protected string $dataPath = __DIR__.'/../data_in/authorization';
    protected string $outPath = __DIR__.'/../data_out/authorization';

    public function test_basic_tags_exist()
    {
        $this->assertRouteHasTagsCount(2, 'User partial update', $this->project);
        $this->assertRouteIsSecured('User partial update', $this->project);
    }
}