<?php

use Multidoc\Services\DIService;
use Multidoc\Services\MultidocService;

require_once '..\vendor\autoload.php';
require_once '..\Services\DIService.php';

$service = DIService::load();
/**
 * @var $multidoc MultidocService
 */
$multidoc = $service->get('multidoc_service');

$multidoc->generate(__DIR__.'\input\basic','output\basic');
$multidoc->generate(__DIR__.'\input\basic_minimized','output\basic_minimized');
$multidoc->generate(__DIR__.'\input\environments','output\environments');
$multidoc->generate(__DIR__.'\input\tags','output\tags');
$multidoc->generate(__DIR__.'\input\authorization','output\authorization');
$multidoc->generate(__DIR__.'\input\multiple categories','output\multiple categories');
$multidoc->generate(__DIR__.'\input\project logo','output\project logo');
$multidoc->generate(__DIR__.'\input\files','output\files');

//Project logo as project for ALL
$multidoc->generate(__DIR__.'\input','output\all',array(
        __DIR__.'\input\basic\basic_project.yml',
        __DIR__.'\input\basic_minimized\basic_project.yml',
        __DIR__.'\input\environments\project.yml',
        __DIR__.'\input\tags\project.yml',
        __DIR__.'\input\authorization\project.yml',
        __DIR__.'\input\multiple categories\project.yml',
        //Project logo definition excluded here
        __DIR__.'\input\files\project.yml',
    )
);