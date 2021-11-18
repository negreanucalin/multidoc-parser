<?php

namespace MultidocParser\Tests\Feature;

use MultidocParser\Services\DIService;
use MultidocParser\Services\FileContentParserService;
use MultidocParser\Services\InputFileService;

class BasicFeatureTest extends MultidocParserTestFeature
{
    private InputFileService $fileService;
    private FileContentParserService $parser;

    public function setUp(): void
    {
        $service = (new DIService())->load();
        $this->fileService = $service->get('input_file_service');
        $this->parser = $service->get('file_content_parser_service');
    }

    public function test_basic()
    {
        $fileList = $this->fileService->getFileListFromPath(__DIR__.'/../data/basic');
        $project = $this->parser->getProjectFromFileList($fileList);

        $this->assertEquals('My Awesome project basic', $project->name);
        $this->assertEquals('basicVersion', $project->version);
        $this->assertEquals('My Awesome project basic description', $project->description);

        $this->assertCount(1, $project->categories, 1);
        $this->assertEquals('Basic', $project->categories[0]->name);

        $this->assertCount(6, $project->categories[0]->routeList);

        foreach ($project->categories[0]->routeList as $route) {
            $this->assertEquals('Basic', $route->category->name);
            $this->assertEquals('basic_1', $route->categoryId);
        }
    }
}