<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Project;
use Xsolla\SDK\Protocol\ProtocolBuilder;
use Xsolla\SDK\User;
use Xsolla\SDK\Protocol\Storage\UserStorageInterface;
use Xsolla\SDK\Protocol\Storage\PaymentStandardStorageInterface;
use Xsolla\SDK\Exception\UnprocessableRequestException;

class PaymentStandardDemoStorage implements PaymentStandardStorageInterface
{
    public function cancel($invoiceId)
    {
        //do nothing
    }

    public function pay($invoiceId, $amountVirtual, User $user, $dryRun)
    {
        if (1 == $invoiceId) {
            return time();//"unique" id
        }
        throw new UnprocessableRequestException('Demo unprocessable error response');
    }
}

class UsersDemoStorage implements UserStorageInterface
{
    public function check(User $user)
    {
        return 'demo' === $user->getV1();
    }

    public function getSpec(User $user)
    {
        return array();
    }
}

$usersStorage = new UsersDemoStorage;
$paymentsStorage = new PaymentStandardDemoStorage;
$demoProject = new Project(
    '4783',//demo project id
    'key'//demo project secret key
);
$protocolBuilder = new ProtocolBuilder($demoProject);
$protocol = $protocolBuilder->getStandardProtocol($usersStorage, $paymentsStorage);

$request = Request::createFromGlobals();
$response = $protocol->run($request);
$response->send();
