<?php

namespace Xsolla\SDK\User;


use Xsolla\SDK\Invoice;
use Xsolla\SDK\Storage\ProjectInterface;
use Xsolla\SDK\User;

class Subscription
{
    const TYPE_CARD = 'card';
    const TYPE_PAYPAL = 'paypal';
    const TYPE_YANDEX = 'yandex';
    const TYPE_WEBMONEY = 'wm';

    /**
     * @var ProjectInterface
     */
    protected $project;

    public function __construct(ProjectInterface $project)
    {
        $this->project = $project;
    }

    public function search(User $user, $type = null)
    {

    }

    public function pay($subscriptionId, Invoice $invoice, $type)
    {

    }

    public function delete($subscriptionId, $type)
    {

    }
} 