<?php

namespace Xsolla\SDK\Invoicing;

class QiwiWallet extends MobilePayment
{
    protected $xsd_path_calculate = '/../../resources/schema/qiwi/calculate.xsd';
    protected $xsd_path_invoice = '/../../resources/schema/qiwi/invoice.xsd';

    protected $url = 'invoicing/index.php';

    public function send(array $queryParams, $schemaFilename)
    {
        $queryParams['ps'] = 'qiwi';

        return parent::send($queryParams, $schemaFilename);
    }
}
