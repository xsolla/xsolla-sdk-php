<?php

namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Storage\PaymentsCashInterface;
use Xsolla\SDK\Project;

class PayCash extends Command
{
    const CODE_SUCCESS = 0;
    const CODE_ERROR_TEMPORARY = 30;

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
            $this->payments->pay(
                $request->query->get('id'),
                $request->query->get('amount'),
                $request->query->get('v1'),
                $request->query->get('v2'),
                $request->query->get('v3'),
                $request->query->get('currency'),
                $request->query->get('date'),
                $request->query->get('userAmount'),
                $request->query->get('userCurrency'),
                $request->query->get('transferAmount'),
                $request->query->get('transferCurrency'),
                $request->query->get('pid'),
                $request->query->get('geotype')
            );

            return array('result' => self::CODE_SUCCESS);
        } catch (\Exception $e) {
            return array('result' => self::CODE_ERROR_TEMPORARY, 'description' => $e->getMessage());
        }
    }

    public function checkSign(Request $request)
    {
        $actualSign = $this->generateSign($request, array('v1', 'amount', 'currency', 'id'));
        return $actualSign == $request->query->get('sign');
    }
}
