<?php

require_once(__DIR__ . '/_bootstrap.php');

use RingCentral\http\HttpException;
use RingCentral\http\Response;
use RingCentral\SDK;

$credentials = require(__DIR__ . '/_credentials.php');

// Create SDK instance

$rcsdk = new SDK($credentials['appKey'], $credentials['appSecret'], $credentials['server']);

$platform = $rcsdk->getPlatform();

// Authorize

$platform->authorize($credentials['username'], $credentials['extension'], $credentials['password'], true);

// Load something nonexistent

try {

    $platform->get('/account/~/whatever');

} catch (HttpException $e) {

    $response = $e->getTransaction()->getResponse();

    $message = $e->getMessage() . ' (from backend) at URL ' . $e->getTransaction()->getRequest()->getUri()->__toString();

    print 'Expected HTTP Error: ' . $message . PHP_EOL;

}
