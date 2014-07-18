<?php
namespace Xsolla\SDK\Tests\PaymentPage;

use Xsolla\SDK\Invoice;
use Xsolla\SDK\PaymentPage\UrlBuilder;
use Xsolla\SDK\Project;
use Xsolla\SDK\User;

class UrlBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UrlBuilder
     */
    protected $urlBuilder;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Invoice
     */
    protected $invoice;

    /**
     * @var Project
     */
    protected $project;

    protected $defaultUrl = 'https://secure.xsolla.com/paystation2/?project=7096&sign=094eb3c634f2612dead38608dc20eaec';

    protected $sandboxUrl = 'https://sandbox-secure.xsolla.com/paystation2/?project=7096&sign=d9ff2b0438b8eb23d0cddc4a931eff92';

    protected $urlWithHiddenParameters = 'https://secure.xsolla.com/paystation2/?out=1.11&currency=EUR&project=7096&sign=5bbc52cd72d7b3491025a7d6cca0cb70';

    protected $urlWithUserDetailsAndClearedSignedParameters = 'https://secure.xsolla.com/paystation2/?v1=user_v1&v2=user_v2&v3=user_v3&email=email%40example.com&userip=user_userIp&phone=user_phone&project=7096&signparams=allowSubscription%2Ccurrency%2Cfastcheckout%2Cid_package%2Cout%2Cproject%2Csignparams%2Ctheme%2Cv0&sign=5b7c4eab43356844ec631771121277f5';

    protected $urlWithInvoiceAndWithoutSignparams = 'https://secure.xsolla.com/paystation2/?out=1.11&currency=EUR&project=7096&sign=5bbc52cd72d7b3491025a7d6cca0cb70';

    protected $fullUrl = 'https://secure.xsolla.com/paystation2/?local=EN&country=US&limit=14&v1=user_v1&v2=user_v2&v3=user_v3&email=email%40example.com&userip=user_userIp&phone=user_phone&out=1.11&currency=EUR&sum=0.1&project=7096&hidden=limit&signparams=allowSubscription%2Ccurrency%2Cemail%2Cfastcheckout%2Cid_package%2Climit%2Cout%2Cphone%2Cproject%2Csignparams%2Csum%2Ctheme%2Cuserip%2Cv0%2Cv2%2Cv3&sign=a56aaed28a810577e075f4d665031d30';

    public function setUp()
    {
        $this->user = new User('user_v1');
        $this->user->setV2('user_v2');
        $this->user->setV3('user_v3');
        $this->user->setEmail('email@example.com');
        $this->user->setPhone('user_phone');
        $this->user->setUserIp('user_userIp');

        $this->invoice = new Invoice;
        $this->invoice->setCurrency('EUR');
        $this->invoice->setVirtualCurrencyAmount(1.11);

        $this->project = new Project(7096, 'KEY');

        $this->urlBuilder = new UrlBuilder($this->project);
    }

    public function testGetLink()
    {
        $this->assertSame($this->defaultUrl, $this->urlBuilder->getUrl());
    }

    public function testGetLinkSandbox()
    {
        $this->assertSame($this->sandboxUrl, $this->urlBuilder->getUrl(UrlBuilder::SANDBOX_URL));
    }

    public function testIgnoreBlankParameters()
    {
        $this->urlBuilder->setParameter('description', '');
        $this->testGetLink();
    }

    public function testClear()
    {
        $this->urlBuilder->setCountry('US')
            ->clear();
        $this->testGetLink();
    }

    public function testHiddenParameters()
    {
        $this->urlBuilder->setInvoice($this->invoice);
        $this->assertSame($this->urlWithHiddenParameters, $this->urlBuilder->getUrl());
    }

    public function testClearSignedParameters()
    {
        $this->urlBuilder->setUser($this->user, false);
        $this->assertSame($this->urlWithUserDetailsAndClearedSignedParameters, $this->urlBuilder->getUrl());
    }

    public function testDefaultSignedParameters()
    {
        $this->urlBuilder->setInvoice($this->invoice)
            ->unlockParameterForUser('currency')
            ->unlockParameterForUser('currency')
            ->lockParameterForUser('currency');
        $this->assertSame($this->urlWithInvoiceAndWithoutSignparams, $this->urlBuilder->getUrl());
    }

    public function testFluentInterface()
    {
        $this->invoice->setAmount(0.1);

        $url = $this->urlBuilder->clear()
            ->setLocale('EN')
            ->setCountry('US')
            ->setParameter('limit', 14, true, true)
            ->setUser($this->user, true, false)
            ->setInvoice($this->invoice, true, false)
            ->unlockParameterForUser('v1')
            ->lockParameterForUser('limit')
            ->getUrl();
        $this->assertSame($this->fullUrl, $url);
    }
}
