<?php

namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Exception\InvoiceNotBeRollbackException;
use Xsolla\SDK\Exception\InvoiceNotFoundException;
use Xsolla\SDK\Storage\PaymentsInterface;
use Xsolla\SDK\Project;

class Cancel extends Command
{
    protected $payments;

    public function __construct(Project $project, PaymentsInterface $payments)
    {
        $this->project = $project;
        $this->payments = $payments;
    }

    public function process(Request $request)
    {
        try {
            $this->payments->cancel($request->query->get('id'));

            return array(
                'result' => '0'
            );
        } catch (InvoiceNotFoundException $e) {
            return array(
                'result' => '2',
                'comment' => 'The payment specified in the request is not found in the system'
            );
        } catch (InvoiceNotBeRollbackException $e) {
            return array(
                'result' => '7',
                'comment' => 'The payment cannot be canceled'
            );
        }
    }

    public function checkSign(Request $request)
    {
        return ($this->generateSign($request, array('command', 'id')) == $request->query->get('md5'));
    }

    public function getRequiredParams()
    {
        return array('command', 'md5', 'id');
    }
}
