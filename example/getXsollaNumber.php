<?php

use Guzzle\Http\Client;
use Xsolla\SDK\Project;
use Xsolla\SDK\User\Number;
use Xsolla\SDK\User;

require_once __DIR__.'/../vendor/autoload.php';

$user = new User('v1', 'v2', 'v3', 'example@example.com');

$demoProject = new Project(
    '4783',//demo project id
    'key'//demo project secret key
);

$number = new Number(new Client('https://api.xsolla.com'), $demoProject);
echo $number->getNumber($user);
