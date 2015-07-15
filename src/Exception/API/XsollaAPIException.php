<?php

namespace Xsolla\SDK\Exception\API;

use Guzzle\Http\Message\Response;
use Guzzle\Plugin\ErrorResponse\ErrorResponseExceptionInterface;
use Guzzle\Service\Command\CommandInterface;
use Xsolla\SDK\Exception\XsollaException;

class XsollaAPIException extends XsollaException implements ErrorResponseExceptionInterface
{
    protected $messageTemplate =
<<<EOF
Xsolla API Error Response: %s

Response:
================
%s

Request:
================
%s
EOF;

    protected $command;

    protected $response;

    public function __construct(CommandInterface $command, Response $response)
    {
        $this->command = $command;
        $this->response = $response;
        $errorDetails = json_decode($response->getBody('true'), true);
        if ($errorDetails and isset($errorDetails['message'])) {
            $errorMessage = $errorDetails['message'];
        } else {
            $errorMessage = '';
        }
        $message = sprintf($this->messageTemplate, $errorMessage, $response->__toString(), $command->getRequest()->__toString());
        parent::__construct($message);
    }

    public static function fromCommand(CommandInterface $command, Response $response)
    {
        return new static($command, $response);
    }


}