<?php

use Guzzle\Http\Client;
use Xsolla\SDK\Api\NumberApi;
use Xsolla\SDK\Project;
use Xsolla\SDK\User;

require_once __DIR__.'/../vendor/autoload.php';

$user = new User('v1', 'v2', 'v3', 'example@example.com');

$demoProject = new Project(
    '4783', //demo project id
    'key'   //demo project secret key
);

$numberApi = new NumberApi(new Client(), $demoProject);
echo $numberApi->getNumber($user);
