<?php

namespace Xsolla\SDK\IPN;

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
            call_user_func($this->IPNCallback, $IPNRequest->getParsedBody());
            $IPNResponse = new IPNResponse();
            $IPNResponse->sendResponse();
        } catch (\Exception $e) {
            IPNResponse::fromException($e)->sendResponse();
        }
    }
}