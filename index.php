<?php
require_once 'vendor/autoload.php';
require_once 'Services/DIService.php';

$service =  \Multidoc\Services\DIService::load();
$fac = $service->get('multidoc_service');
var_dump($fac);