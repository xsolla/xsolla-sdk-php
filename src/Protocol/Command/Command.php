<?php

namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Exception\InvalidRequestException;
use Xsolla\SDK\Exception\InvalidSignException;
use Xsolla\SDK\Project;
use Xsolla\SDK\Protocol\Protocol;

abstract class Command
{
    const CODE_SUCCESS = 0;

    /**
     * @var Protocol
     */
    protected $protocol;

    /**
     * @var Project
     */
    protected $project;

    protected $commentFieldName = 'comment';

    public function getResponse(Request $request)
    {
        if (!$this->checkRequiredParams($request)) {
            throw new InvalidRequestException(sprintf(
                'Invalid request format. Not enough arguments. Required: "%s". But received: "%s".',
                join('", "', $this->getRequiredParams()),
                join('", "', $request->query->keys())
            ));
        }

        if (!$this->checkSign($request)) {
            throw new InvalidSignException('Invalid md5 signature');
        }

        return $this->process($request);
    }

    public function checkRequiredParams(Request $request)
    {
        $requiredParameters = $this->getRequiredParams();

        foreach ($requiredParameters as $param) {
            $value = $request->query->get($param);
            if (empty($value)) {
                return false;
            }
        }

        return true;
    }

    public function generateSign(Request $request, $parameters)
    {
        $signString = '';
        foreach ($parameters as $parameter) {
            $signString .= $request->query->get($parameter);
        }

        return md5($signString . $this->project->getSecretKey());
    }

    protected function getDateTimeXsolla($format, $datetime)
    {
        $xsollaTimeZone = new \DateTimeZone('Europe/Moscow');
        $datetimeObj = \DateTime::createFromFormat($format, $datetime, $xsollaTimeZone);
        if (!$datetimeObj) {
            throw new InvalidRequestException(sprintf('Datetime string %s could not be converted to DateTime object from format \'%s\'', $datetime, $format));
        }
        $datetimeObj->setTimezone(new \DateTimeZone(date_default_timezone_get()));

        return $datetimeObj;
    }

    abstract public function checkSign(Request $request);

    abstract public function process(Request $request);

    abstract public function getRequiredParams();

    abstract public function getInvalidSignResponseCode();

    abstract public function getInvalidRequestResponseCode();

    abstract public function getCommentFieldName();

    abstract public function getUnprocessableRequestResponseCode();

    abstract public function getTemporaryServerErrorResponseCode();
}
