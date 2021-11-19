<?php

namespace MultidocParser\Tests\Feature;

use MultidocParser\Tests\MultidocParserTestFeature;

class HeadersAndResponseFeatureTest extends MultidocParserTestFeature
{
    protected string $dataPath = __DIR__.'/../data_in/headers_and_response';
    protected string $outPath = __DIR__.'/../data_out/headers_and_response';

    public function test_basic_headers_response_exist()
    {

        $this->assertRouteHasHeaders(
            [
                'Content-Type'=> 'application/vnd.test-multidoc.v1+json'
            ],
            'User authentication',
            $this->project
        );
    }

}