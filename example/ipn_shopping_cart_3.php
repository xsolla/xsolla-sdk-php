<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Exception\InvoiceNotFoundException;
use Xsolla\SDK\Project;
use Xsolla\SDK\Protocol\ProtocolFactory;
use Xsolla\SDK\Protocol\Storage\PaymentShoppingCart3StorageInterface;
use Xsolla\SDK\User;
use Xsolla\SDK\Protocol\Storage\UserStorageInterface;
use Xsolla\SDK\Exception\UnprocessableRequestException;

class PaymentShoppingCart3DemoStorage implements PaymentShoppingCart3StorageInterface
{
    public function cancel($xsollaPaymentId, $reasonCode = NULL, $reasonDescription = NULL)
    {
        if (1 == $xsollaPaymentId) {
            return;
        }
        throw new InvoiceNotFoundException();
    }

    public function pay($xsollaPaymentId, $paymentAmount, $paymentCurrency, User $user, \DateTime $date, $dryRun)
    {
        if (1 == $xsollaPaymentId) {
            return time();//"unique" id
        }
        throw new UnprocessableRequestException('Demo unprocessable error response');
    }
}

class UsersDemoStorage implements UserStorageInterface
{
    public function isUserExists(User $user)
    {
        return 'demo' === $user->getV1();
    }

    public function getAdditionalUserFields(User $user)
    {
        return array();
    }
}

$userStorage = new UsersDemoStorage;
$paymentStorage = new PaymentShoppingCart3DemoStorage;

$demoProject = new Project(
    '4783',//demo project id
    'key'//demo project secret key
);
$protocolBuilder = new ProtocolFactory($demoProject);
$protocol = $protocolBuilder->getShoppingCart3Protocol($userStorage, $paymentStorage);

$request = Request::createFromGlobals();
$response = $protocol->run($request);
$response->send();
