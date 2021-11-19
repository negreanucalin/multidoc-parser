<?php

namespace MultidocParser\Tests\Feature;

use MultidocParser\Tests\MultidocParserTestFeature;

class HeadersFeatureTest extends MultidocParserTestFeature
{
    protected string $dataPath = __DIR__.'/../data_in/headers';
    protected string $outPath = __DIR__.'/../data_out/headers';

    public function test_basic_headers_exist()
    {

        $this->assertRouteHasHeaders(
            [
                'Content-Type'=> 'application/vnd.test-multidoc.v1+json',
                'Accept'=> 'application/vnd.test-multidoc.v1+json'
            ],
            'User authentication',
            $this->project
        );
    }

}