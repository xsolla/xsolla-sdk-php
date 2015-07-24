<?php
require __DIR__ . '/../../vendor/autoload.php';

use Xsolla\SDK\Tests\Integration\Webhook\ServerMock;

$server = new ServerMock();
$server->run($_GET['test_case']);