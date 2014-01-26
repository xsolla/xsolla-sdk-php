<?php

namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Storage\PaymentsCashInterface;
use Xsolla\SDK\Project;

class PayCash extends Command
{

    /**
     * @var PaymentsCashInterface
     */
    protected $payments;

    public function __construct(Project $project, PaymentsCashInterface $payments)
    {
        $this->project = $project;
        $this->payments = $payments;
    }

    public function getRequiredParams()
    {
        return array('command', 'md5', 'id', 'v1', 'amount', 'currency', 'datetime');
    }

    public function process(Request $request)
    {
        try {
            $id = $this->payments->pay(
                $request->get('id'),
                $request->get('amount'),
                $request->get('v1'),
                $request->get('v2'),
                $request->get('v3'),
                $request->get('currency'),
                $request->get('date'),
                $request->get('userAmount'),
                $request->get('userCurrency'),
                $request->get('transferAmount'),
                $request->get('transferCurrency'),
                $request->get('pid'),
                $request->get('geotype')
            );

            return array(
                'result' => '0',
                'description' => 'Success',
                'fields' => array(
                    'id' => $request->get('id'),
                    'order' => $request->get('v1'),
                    'id_shop' => $id,
                    'amount' => $request->get('amount'),
                    'currency' => $request->get('currency'),
                    'datetime' => $request->get('datetime'),
                    'sign' => $request->get('sign')
                )
            );
        } catch (\Exception $e) {
            return array('result' => '5', 'comment' => $e->getMessage());
        }
    }

    public function checkSign(Request $request)
    {
        return ($this->generateSign($request, array('v1', 'amount', 'currency', 'id')) == $request->get('sign'));
    }
}
