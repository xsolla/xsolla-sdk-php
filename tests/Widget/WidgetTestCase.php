<?php
namespace Xsolla\SDK\Tests\Widget;

use Xsolla\SDK\Invoice;
use Xsolla\SDK\Project;
use Xsolla\SDK\User;
use Xsolla\SDK\Widget\Widget;

abstract class WidgetTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Widget
     */
    protected $widget;

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

    protected $defaultUrl;

    protected $urlWithHiddenParameters;

    protected $urlWithUserDetailsAndClearedSignedParameters;

    protected $urlWithInvoiceAndWithoutSignparams;

    protected $fullUrl;

    public function setUp()
    {
        $this->user = new User('user_v1');
        $this->user->setV2('user_v2');
        $this->user->setV3('user_v3');
        $this->user->setEmail('user_email');
        $this->user->setPhone('user_phone');
        $this->user->setUserIp('user_userIp');

        $this->invoice = new Invoice;
        $this->invoice->setCurrency('EUR');
        $this->invoice->setOut(1.11);

        $this->project = new Project(7096, 'KEY');
    }

    public function testGetLink()
    {
        $this->assertSame($this->defaultUrl, $this->widget->getLink());
    }

    public function testIgnoreBlankParameters()
    {
        $this->widget->setParameter('description', '');
        $this->testGetLink();
    }

    public function testClear()
    {
        $this->widget->setCountry('US')
            ->clear();
        $this->testGetLink();
    }

    public function testHiddenParameters()
    {
        $this->widget->setLocale('EN', true);
        $this->assertSame($this->urlWithHiddenParameters, $this->widget->getLink());
    }

    public function testClearSignedParameters()
    {
        $this->widget->setUser($this->user)
            ->clearSignedParameters();
        $this->assertSame($this->urlWithUserDetailsAndClearedSignedParameters, $this->widget->getLink());
    }

    public function testDefaultSignedParameters()
    {
        $this->widget->setInvoice($this->invoice)
            ->removeFromSignedParameters('currency')
            ->addToSignedParameters('currency');
        $this->assertSame($this->urlWithInvoiceAndWithoutSignparams, $this->widget->getLink());
    }

    public function testFluentInterface()
    {
        $url = $this->widget->clear()
            ->clearSignedParameters()
            ->setLocale('EN')
            ->setCountry('US')
            ->setParameter('limit', 14, true, true)
            ->setUser($this->user, true, false)
            ->setInvoice($this->invoice, true, false)
            ->removeFromSignedParameters('v1')
            ->addToSignedParameters('limit')
            ->getLink();
        $this->assertSame($this->fullUrl, $url);
    }
}
