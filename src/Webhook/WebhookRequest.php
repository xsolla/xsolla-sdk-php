<?php

namespace Xsolla\SDK\Webhook;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Exception\Webhook\InvalidParameterException;
use Xsolla\SDK\Exception\Webhook\XsollaWebhookException;

class WebhookRequest
{
    protected static $codes = array(
        JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded.',
        JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded.',
        JSON_ERROR_NONE => 'No error has occurred.',
        JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON.',
        JSON_ERROR_SYNTAX => 'Syntax error.',
        JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded.',
    );

    /**
     * @var string
     */
    protected $body;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var string
     */
    protected $clientIp;

    /**
     * @return WebhookRequest
     *
     * @throws XsollaWebhookException
     */
    public static function fromGlobals()
    {
        $request = Request::createFromGlobals();
        $headers = array();
        foreach ($request->headers->all() as $header => $arrayValue) {
            $headers[$header] = $arrayValue[0];
        }

        return new static($headers, $request->getContent(), $request->getClientIp());
    }

    /**
     * @param array  $headers
     * @param string $body
     * @param string $clientIp
     */
    public function __construct(array $headers, $body, $clientIp = null)
    {
        $this->headers = $headers;
        $this->body = $body;
        $this->clientIp = $clientIp;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return array
     *
     * @throws XsollaWebhookException
     */
    public function toArray()
    {
        $data = json_decode($this->body, true);
        $jsonLastError = json_last_error();
        if (JSON_ERROR_NONE !== $jsonLastError) {
            $message = 'Unknown error.';
            if (array_key_exists($jsonLastError, self::$codes)) {
                $message = self::$codes[$jsonLastError];
            }
            throw new InvalidParameterException('Unable to parse Xsolla webhook request into JSON: '.$message);
        }

        return $data === null ? array() : $data;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getClientIp()
    {
        return $this->clientIp;
    }
}
