<?php

use Guzzle\Http\Client;
use Xsolla\SDK\Storage\Project;
use Xsolla\SDK\User\Number;
use Xsolla\SDK\User;

require_once __DIR__.'/../vendor/autoload.php';

$user = new User('v1', 'v2', 'v3', 'example@example.com');

$number = new Number(new Client('https://api.xsolla.com'), new Project());
echo $number->getNumber($user);
