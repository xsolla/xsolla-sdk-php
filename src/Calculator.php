<?php

namespace Xsolla\SDK;

use Guzzle\Http\Client;

class Calculator
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function calculateOut($geotypeId, $amount)
    {

    }

    public function calculateIn($geotypeId, $amountVirtual)
    {

    }
} 