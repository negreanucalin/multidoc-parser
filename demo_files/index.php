<?php

use Multidoc\Services\DIService;
use Multidoc\Services\MultidocService;

require_once '../vendor/autoload.php';
require_once '../Services/DIService.php';

$service = DIService::load();
/**
 * @var $multidoc MultidocService
 */
$multidoc = $service->get('multidoc_service');

$multidoc->generate(__DIR__.'/input/basic','output/basic');
$multidoc->generate(__DIR__.'/input/basic_minimized','output/basic_minimized');
$multidoc->generate(__DIR__.'/input/environments/','output/environments');