<?php
namespace Xsolla\SDK\Tests\PaymentPage;

use Xsolla\SDK\PaymentPage\UrlBuilderFactory;
use Xsolla\SDK\Project;

class UrlBuilderFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Project
     */
    protected $project;

    /**
     * @var UrlBuilderFactory
     */
    private $urlBuilderFactory;
    
    public function setUp()
    {
        $this->project = new Project(7096, 'KEY');
        $this->urlBuilderFactory = new UrlBuilderFactory($this->project);
    }

    public function testGetPayStation()
    {
        $url = $this->urlBuilderFactory->getPayStation()->getUrl();
        $this->assertSame(
            'https://secure.xsolla.com/paystation2/?marketplace=paystation&project=7096&sign=094eb3c634f2612dead38608dc20eaec',
            $url
        );
    }

    public function testGetCreditCards()
    {
        $url = $this->urlBuilderFactory->getCreditCards()->getUrl();
        $this->assertSame(
            'https://secure.xsolla.com/paystation2/?marketplace=landing&pid=1380&theme=201&project=7096&sign=457a3f06ea55593b6204b992963cf762',
            $url
        );
    }

    public function testGetPayDesk()
    {
        $url = $this->urlBuilderFactory->getPayDesk()->getUrl();
        $this->assertSame(
            'https://secure.xsolla.com/paystation2/?marketplace=paydesk&project=7096&sign=094eb3c634f2612dead38608dc20eaec',
            $url
        );
    }

    public function testGetMobilePayment()
    {
        $url = $this->urlBuilderFactory->getMobilePayment()->getUrl();
        $this->assertSame(
            'https://secure.xsolla.com/paystation2/?marketplace=landing&theme=201&pid=1738&project=7096&sign=457a3f06ea55593b6204b992963cf762',
            $url
        );
    }

    public function testGetDirectPayment()
    {
        $url = $this->urlBuilderFactory->getDirectPayment(6)->getUrl();
        $this->assertSame(
            'https://secure.xsolla.com/paystation2/?marketplace=landing&pid=6&project=7096&sign=094eb3c634f2612dead38608dc20eaec',
            $url
        );
    }

    public function testGetMobileVersion()
    {
        $url = $this->urlBuilderFactory->getMobileVersion()->getUrl();
        $this->assertSame(
            'https://secure.xsolla.com/paystation2/?marketplace=mobile&project=7096&sign=094eb3c634f2612dead38608dc20eaec',
            $url
        );
    }
}
