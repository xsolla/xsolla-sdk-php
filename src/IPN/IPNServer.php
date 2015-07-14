<?php

namespace Xsolla\SDK\IPN;

use Symfony\Component\HttpFoundation\Response;
use Xsolla\SDK\Exception\IPN\XsollaIPNException;
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
     * @param string $projectSecretKey
     * @return IPNServer
     */
    public static function create($IPNCallback, $projectSecretKey)
    {
        return new static($IPNCallback, new IPNAuthenticator($projectSecretKey));
    }

    /**
     * @param callable $IPNCallback
     * @param IPNAuthenticator $IPNAuthenticator
     * @throws XsollaIPNException
     */
    public function __construct($IPNCallback, IPNAuthenticator $IPNAuthenticator)
    {
        if (!is_callable($IPNCallback)) {
            throw new XsollaIPNException();
        }
        $this->IPNCallback = $IPNCallback;
        $this->IPNAuthenticator = $IPNAuthenticator;
    }

    /**
     * @param IPNRequest $IPNRequest
     * @param bool $authenticateClientIp
     */
    public function start(IPNRequest $IPNRequest = null, $authenticateClientIp = true)
    {
        $response = $this->getSymfonyResponse($IPNRequest, $authenticateClientIp);
        $response->send();
    }

    /**
     * @param IPNRequest $IPNRequest
     * @param bool $authenticateClientIp
     * @return Response
     */
    public function getSymfonyResponse(IPNRequest $IPNRequest = null, $authenticateClientIp = true)
    {
        try {
            if (!$IPNRequest) {
                $IPNRequest = IPNRequest::fromGlobals();
            }
            $this->IPNAuthenticator->authenticate($IPNRequest, $authenticateClientIp);
            $message = Message::fromParameterBag($IPNRequest->getParameterBag());
            call_user_func($this->IPNCallback, $message);
            $IPNResponse =  new IPNResponse();
            return $IPNResponse->getSymfonyResponse();
        } catch (\Exception $e) {
            return IPNResponse::fromException($e)->getSymfonyResponse();
        }
    }
}