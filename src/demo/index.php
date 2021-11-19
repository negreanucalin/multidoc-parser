<?php

use MultidocParser\Services\DIService;
use MultidocParser\Services\MultidocParserService;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Services/DIService.php';

$service = (new DIService())->load();
/**
 * @var $multidoc MultidocParserService
 */
$multidoc = $service->get('multidoc_parser_service');

//Project logo as project for ALL
$multidoc->generate(
    __DIR__ . '/../../tests/data_in',__DIR__.'/output_all',
    array(
        __DIR__.'/../../tests/data_in/authorization/project.yml',
        __DIR__.'/../../tests/data_in/basic/basic_project.yml',
        __DIR__.'/../../tests/data_in/basic_minimized/basic_project.yml',
        __DIR__.'/../../tests/data_in/environments/project.yml',
        __DIR__.'/../../tests/data_in/files/project.yml',
        __DIR__.'/../../tests/data_in/headers/basic_project.yml',
        __DIR__.'/../../tests/data_in/headers_and_response/basic_project.yml',
        __DIR__.'/../../tests/data_in/multiple_categories/project.yml',
        __DIR__.'/../../tests/data_in/post_json/basic_project.yml',
        __DIR__.'/../../tests/data_in/tags/project.yml',
        __DIR__.'/../../tests/data_in/templates/basic_project.yml',
    )
);