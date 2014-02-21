<?php
require_once __DIR__.'/../vendor/autoload.php';

use Xsolla\SDK\Api\ApiFactory;
use Xsolla\SDK\Project;
use Xsolla\SDK\User;

$user = new User('demo_user');

$demoProject = new Project(
    '4783', //demo project id
    'key'   //demo project secret key
);

$apiFactory = new ApiFactory($demoProject);
$numberApi = $apiFactory->getNumberApi();

$number = $numberApi->getNumber($user) . PHP_EOL;

echo 'Xsolla number for user "demo_user": '. $number . PHP_EOL;
