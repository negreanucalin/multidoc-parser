<?php

namespace MultidocParser\Tests\Feature;

use MultidocParser\Tests\MultidocParserTestFeature;

class BasicFeatureTest extends MultidocParserTestFeature
{

    protected string $dataPath = __DIR__.'/../data_in/basic';
    protected string $outPath = __DIR__.'/../data_out/basic';

    public function test_basic()
    {
        $this->assertEquals('My Awesome project basic', $this->project->name);
        $this->assertEquals('basicVersion', $this->project->version);
        $this->assertEquals('My Awesome project basic description', $this->project->description);

        $this->assertCount(1, $this->project->categories);
        $this->assertProjectHasCategory('Basic', $this->project);
        $this->assertCount(6, $this->project->categories[0]->routeList);

        foreach ($this->project->categories[0]->routeList as $route) {
            $this->assertEquals('Basic', $route->category->name);
            $this->assertEquals('basic_1', $route->categoryId);
        }
    }

    public function test_basic2()
    {
        $this->assertRouteNameExists('User retrieval', $this->project);

        $this->assertRouteHasParamsCount(1, 'User retrieval', $this->project);
        $this->assertRouteHasMethod('GET', 'User retrieval', $this->project);

        $this->assertRouteHasParamsCount(2, 'User activity', $this->project);
        $this->assertRouteHasMethod('GET', 'User activity', $this->project);

        $this->assertRouteHasParameterName('userId','User retrieval', $this->project);

        $this->assertRouteHasNoTags('User activity', $this->project);
    }
}