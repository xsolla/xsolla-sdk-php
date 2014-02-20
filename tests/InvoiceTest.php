<?php
namespace Xsolla\SDK\tests;

use Xsolla\SDK\Invoice;

class InvoiceTest extends \PHPUnit_Framework_TestCase
{
    const ID = 123;
    const SUM = 12.34;
    const OUT = 24.68;
    const CURRENCY = 'USD';

    /**
     * @var Invoice
     */
    protected $invoice;

    public function setUp()
    {
        $this->invoice = new Invoice;
    }

    public function testConstructor()
    {
        $invoice = new Invoice(self::OUT, self::SUM, self::CURRENCY, self::ID);
        $this->assertSame(self::OUT, $invoice->getVirtualCurrencyAmount());
        $this->assertSame(self::SUM, $invoice->getAmount());
        $this->assertSame(self::CURRENCY, $invoice->getCurrency());
        $this->assertSame(self::ID, $invoice->getId());
    }

    public function testSum()
    {
        $this->assertNull($this->invoice->getAmount());
        $this->invoice->setAmount(self::SUM);
        $this->assertSame(self::SUM, $this->invoice->getAmount());
    }

    public function testOut()
    {
        $this->assertNull($this->invoice->getVirtualCurrencyAmount());
        $this->invoice->setVirtualCurrencyAmount(self::OUT);
        $this->assertSame(self::OUT, $this->invoice->getVirtualCurrencyAmount());
    }

    public function testCurrency()
    {
        $this->assertNull($this->invoice->getCurrency());
        $this->invoice->setCurrency(self::CURRENCY);
        $this->assertSame(self::CURRENCY, $this->invoice->getCurrency());
    }

    public function testId()
    {
        $this->assertNull($this->invoice->getId());
        $this->invoice->setId(self::ID);
        $this->assertSame(self::ID, $this->invoice->getId());
    }
}
