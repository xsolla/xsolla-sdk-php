<?php

use Guzzle\Http\Client;
use Xsolla\SDK\Storage\Project;
use Xsolla\SDK\User\Number;
use Xsolla\SDK\User;

include_once '../vendor/autoload.php';

$user = new User('v1', 'v2', 'v3', 'renatbilalov@gmail.com');

$number = new Number(new Client('https://api.xsolla.com'), new Project());
echo $number->getNumber($user);