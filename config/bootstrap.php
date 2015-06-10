<?php

require_once __DIR__ . '/../vendor/autoload.php';

$container = new \Go\Core\Container();

$container->share('logger', function () {
    $nameLog = (new DateTime())->format('Y-m-d') . 'log';
    $stream = new Monolog\Handler\StreamHandler(__DIR__ . '/../logs/' . $nameLog);
    $logger = new \Monolog\Logger('CLICKBUS.CORE');
    $logger->pushHandler($stream);

    return $logger;
});

$container->share('cache.client', function () {
    $redis = new Redis();
    $redis->connect('localhost');

    return $redis;
});

$container->share('cache.service', function ($container)  {
    $cache = new \Clickbus\Cache\CacheService($container->get('cache.client'));
    return $cache;
});

$container->share('client.clickbus', function() {
    $config = [
        'base_url' => 'https://api.clickbus.com.co/api/v2/'
    ];
    $clientHttp = new \GuzzleHttp\Client();
    $client = new \Clickbus\Driver\Clickbus\Client($clientHttp, $config);

    return $client;
});

$container->share('service.search', function($container) {

    $search = new \Clickbus\Model\Search($container->get('client.clickbus'));
    return $search;
});


$applicationAspectKernel = \Clickbus\ApplicationAspectKernel::getInstance();

$applicationAspectKernel->setContainer($container);
$applicationAspectKernel->init(array(
    'debug' => true, // use 'false' for production mode
    // Cache directory
    'cacheDir'  => __DIR__ . '/../cache',
    // Include paths restricts the directories where aspects should be applied, or empty for all source files
    'includePaths' => array(
        __DIR__ . '/../src/'
    )
));
