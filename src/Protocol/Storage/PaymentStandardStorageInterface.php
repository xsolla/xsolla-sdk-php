<?php

namespace Xsolla\SDK\Protocol\Storage;

use Xsolla\SDK\Exception\UnprocessableRequestException;
use Xsolla\SDK\User;

interface PaymentStandardStorageInterface extends PaymentStorageInterface
{
    /**
     * @param int $xsollaPaymentId
     * @param float $amountVirtual
     * @param User $user
     * @param \DateTime $date
     * @param bool $dryRun
     * @return int Payment unique ID in your system
     * @throws UnprocessableRequestException
     */
    public function pay($xsollaPaymentId, $amountVirtual, User $user, \DateTime $date, $dryRun);
}
