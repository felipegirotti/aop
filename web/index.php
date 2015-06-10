<?php

require_once __DIR__ . '/../config/bootstrap.php';

//emulate search

$results = $container->get('service.search')->getSearch(
    '946476023541c33fd03c871.85197381',
    '832268763541c30f114a404.60529478',
    '566893409541c8f18a48e14.74726760',
    new \DateTime('2015-06-20')
);

header('Content-Type: application/json; charset=utf-8');

var_dump($results);