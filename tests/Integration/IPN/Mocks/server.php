<?php
require __DIR__.'/../../../../vendor/autoload.php';

use Xsolla\SDK\Tests\Integration\IPN\Mocks\ServerMock;

$server = new ServerMock();
$server->run($_GET['test_case']);