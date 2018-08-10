<?php

require __DIR__.'/../vendor/autoload.php';

$packager = new \Burgomaster(__DIR__.'/artifacts/staging', __DIR__.'/../');

$packager->exec('rm -rf '.__DIR__.'/artifacts/xsolla.*');

$packager->recursiveCopy('src', 'Xsolla/SDK');
$packager->recursiveCopy('vendor/guzzle/guzzle/src/Guzzle', 'Guzzle', ['php', 'pem']);
$packager->recursiveCopy('vendor/symfony/event-dispatcher', 'Symfony/Component/EventDispatcher');
$packager->recursiveCopy('vendor/symfony/http-foundation', 'Symfony/Component/HttpFoundation');

$packager->createAutoloader([], 'xsolla-autoloader.php');
$packager->createPhar(__DIR__.'/artifacts/xsolla.phar', null, 'xsolla-autoloader.php');
$packager->createZip(__DIR__.'/artifacts/xsolla.zip');

$packager->startSection('test-phar');
$packager->exec('php '.__DIR__.'/test-phar.php');
$packager->endSection();

$packager->exec('rm -rf '.__DIR__.'/artifacts/staging');
