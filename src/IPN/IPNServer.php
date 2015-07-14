<?php

namespace Xsolla\SDK\IPN;

use Xsolla\SDK\IPN\Message\Message;

class IPNServer
{
    /**
     * @var IPNAuthenticator
     */
    protected $IPNAuthenticator;

    /**
     * @var callable
     */
    protected $IPNCallback;

    /**
     * @param callable $IPNCallback
     * @param string $xsollaApiToken
     * @return IPNServer
     */
    public static function create($IPNCallback, $xsollaApiToken)
    {
        return new static($IPNCallback, new IPNAuthenticator($xsollaApiToken));
    }

    /**
     * @param callable $IPNCallback
     * @param IPNAuthenticator $IPNAuthenticator
     */
    public function __construct($IPNCallback, IPNAuthenticator $IPNAuthenticator)
    {
        $this->IPNCallback = $IPNCallback;
        $this->IPNAuthenticator = $IPNAuthenticator;
    }

    public function start()
    {
        try {
            $IPNRequest = IPNRequest::fromGlobals();
            $this->IPNAuthenticator->authenticate($IPNRequest);
            $message = Message::fromRequest($IPNRequest->getParameterBag());
            call_user_func($this->IPNCallback, $message);
            $IPNResponse = new IPNResponse();
            $IPNResponse->sendResponse();
        } catch (\Exception $e) {
            IPNResponse::fromException($e)->sendResponse();
        }
    }
}