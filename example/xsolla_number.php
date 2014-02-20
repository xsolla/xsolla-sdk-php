<?php
require_once __DIR__.'/../vendor/autoload.php';

use Xsolla\SDK\Api\ApiFactory;
use Xsolla\SDK\Project;
use Xsolla\SDK\User;

$user = new User('v1', 'v2', 'v3', 'example@example.com');

$demoProject = new Project(
    '4783', //demo project id
    'key'   //demo project secret key
);

$apiFactory = new ApiFactory($demoProject);
$numberApi = $apiFactory->getNumberApi();

echo $numberApi->getNumber($user);
