<?php
namespace Xsolla\SDK\PaymentPage;

use Xsolla\SDK\Project;

class UrlBuilderFactory
{
    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * @link http://xsolla.github.io/en/paystation.html
     * @return UrlBuilder
     */
    public function getPayStation()
    {
        return new UrlBuilder($this->project, array('marketplace' => 'paystation'));
    }

    /**
     * @link http://xsolla.github.io/en/card.html
     * @return UrlBuilder
     */
    public function getCreditCards()
    {
        return new UrlBuilder(
            $this->project,
            array('marketplace' => 'landing', 'pid'=> 1380, 'theme' => 201)
        );
    }

    /**
     * @link http://xsolla.github.io/en/pswidget.html
     * @return UrlBuilder
     */
    public function getPayDesk()
    {
        return new UrlBuilder($this->project, array('marketplace' => 'paydesk'));
    }

    /**
     * @link http://xsolla.github.io/en/mversion.html
     * @return UrlBuilder
     */
    public function getMobilePayment()
    {
        return new UrlBuilder(
            $this->project,
            array('marketplace' => 'landing', 'theme' => 201, 'pid' => 1738)
        );
    }

    /**
     * @link http://xsolla.github.io/en/directpayment.html
     * @param  int        $pid payment system ID
     * @return UrlBuilder
     */
    public function getDirectPayment($pid)
    {
        return new UrlBuilder($this->project, array('marketplace' => 'landing', 'pid' => $pid));
    }

    /**
     * @link http://xsolla.github.io/en/mversion.html
     * @return UrlBuilder
     */
    public function getMobileVersion()
    {
        return new UrlBuilder($this->project, array('marketplace' => 'mobile'));
    }
}
