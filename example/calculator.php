<?php

use Guzzle\Http\Client;
use Xsolla\SDK\Project;
use Xsolla\SDK\Api\Calculator;

require_once __DIR__.'/../vendor/autoload.php';

$demoProject = new Project(
    '4783', //demo project id
    'key'   //demo project secret key
);

$calculator = new Calculator(new Client(), $demoProject);

// Calculation of the amount of the game currency on the basis of the sum of payment 100 via payment system "1"
echo $calculator->calculateOut(1, 100) . PHP_EOL;

// Calculation of the amount of payment via payment system "1" on the basis of the amount of game currency 100
echo $calculator->calculateIn(1, 100) . PHP_EOL;
