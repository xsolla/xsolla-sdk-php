<?php

namespace Xsolla\SDK\Storage;

interface PaymentsInterface
{

    public function pay();

    public function cancel();
} 