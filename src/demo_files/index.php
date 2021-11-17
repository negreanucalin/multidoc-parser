<?php

use Multidoc\Services\DIService;
use Multidoc\Services\MultidocService;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Services/DIService.php';

$service = (new DIService())->load();
/**
 * @var $multidoc MultidocService
 */
$multidoc = $service->get('multidoc_service');

$multidoc->generate(__DIR__ . '/input/basic','output/basic');
$multidoc->generate(__DIR__ . '/input/basic_minimized','output/basic_minimized');
$multidoc->generate(__DIR__ . '/input/environments','output/environments');
$multidoc->generate(__DIR__ . '/input/tags','output/tags');
$multidoc->generate(__DIR__ . '/input/authorization','output/authorization');
$multidoc->generate(__DIR__ . '/input/multiple categories','output/multiple categories');
$multidoc->generate(__DIR__ . '/input/project logo','output/project logo');
$multidoc->generate(__DIR__ . '/input/files','output/files');
$multidoc->generate(__DIR__ . '/input/headers','output/headers');
$multidoc->generate(__DIR__ . '/input/headers and response','output/headers and response');
$multidoc->generate(__DIR__ . '/input/post json','output/post json');
$multidoc->generate(__DIR__ . '/input/templates','output/templates');

//Project logo as project for ALL
$multidoc->generate(__DIR__ . '/input','output/all',array(
        __DIR__.'/input/basic/basic_project.yml',
        __DIR__.'/input/basic_minimized/basic_project.yml',
        __DIR__.'/input/environments/project.yml',
        __DIR__.'/input/tags/project.yml',
        __DIR__.'/input/authorization/project.yml',
        __DIR__.'/input/multiple categories/project.yml',
        //Project logo definition excluded here
        __DIR__.'/input/files/project.yml',
        __DIR__.'/input/headers/basic_project.yml',
        __DIR__.'/input/headers and response/basic_project.yml',
        __DIR__.'/input/post json/basic_project.yml',
        __DIR__.'/input/templates/basic_project.yml',
    )
);