<?php

use Xsolla\SDK\Storage\Project;
use Xsolla\SDK\User\Number;
use Xsolla\SDK\User;

include '../vendor/autoload.php';

$user = new User('v1', 'v2', 'v3', 'renatbilalov@gmail.com');

$number = new Number(new Project());
echo $number->get($user);