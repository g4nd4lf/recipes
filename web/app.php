<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

$env = getenv('SYMFONY_ENV') !== false ? getenv('SYMFONY_ENV') : 'dev';

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../app/autoload.php';

if ($env === 'dev') {
    Debug::enable();
    $kernel = new AppKernel('dev', true);
} else {
    include_once __DIR__.'/../var/bootstrap.php.cache';
    $kernel = new AppKernel('prod', false);
}

$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
