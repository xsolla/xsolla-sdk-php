<?php

namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Project;

abstract class Command
{
    /**
     * @var Project
     */
    protected $project;

    public function getResponse(Request $request)
    {
        if (!$this->checkRequiredParams($request)) {
            return array(
                'result' => '4',
                'comment' => 'Invalid request format'
            );
        }

        if (!$this->checkSign($request)) {
            return array(
                'result' => '3',
                'comment' => 'Invalid md5 signature'
            );
        }

        return $this->process($request);
    }

    public function checkRequiredParams(Request $request)
    {
        $requiredParameters = $this->getRequiredParams();

        foreach ($requiredParameters as $param) {
            $value = $request->get($param);
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
            $signString .= $request->get($parameter);
        }

        return md5($signString . $this->project->getSecretKey());
    }

    abstract public function checkSign(Request $request);

    abstract public function process(Request $request);

    abstract public function getRequiredParams();
}
