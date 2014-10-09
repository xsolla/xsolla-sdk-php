<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Project;
use Xsolla\SDK\Protocol\ProtocolFactory;
use Xsolla\SDK\User;
use Xsolla\SDK\Protocol\Storage\UserStorageInterface;
use Xsolla\SDK\Protocol\Storage\PaymentStandardStorageInterface;
use Xsolla\SDK\Exception\UnprocessableRequestException;
use Xsolla\SDK\Exception\InvoiceNotFoundException;

class PaymentStandardDemoStorage implements PaymentStandardStorageInterface
{
    public function cancel($xsollaPaymentId, $reasonCode = NULL, $reasonDescription = NULL)
    {
        if($xsollaPaymentId < 1){
            throw new InvoiceNotFoundException();
        }
    }

    public function pay($xsollaPaymentId, $virtualCurrencyAmount, User $user, \DateTime $date, $dryRun)
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
$paymentStorage = new PaymentStandardDemoStorage;

$demoProject = new Project(
    '4783',//demo project id
    'key'//demo project secret key
);
$protocolBuilder = new ProtocolFactory($demoProject);
$protocol = $protocolBuilder->getStandardProtocol($userStorage, $paymentStorage);

$request = Request::createFromGlobals();
$response = $protocol->run($request);
$response->send();
