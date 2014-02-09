<?php

namespace Xsolla\SDK\Storage;

interface PaymentsStandardInterface extends PaymentsInterface
{
    public function pay($invoiceId, $amountVirtual, $v1, $v2, $v3, $dryRun);
}
