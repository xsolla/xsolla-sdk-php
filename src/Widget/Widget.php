<?php

namespace Xsolla\SDK\Widget;

use Xsolla\SDK\Project;
use Xsolla\SDK\User;
use Xsolla\SDK\Invoice;
use Xsolla\SDK\Exception\InvalidArgumentException;

abstract class Widget implements WidgetInterface
{
    const BASE_URL = 'https://secure.xsolla.com/paystation2/?';

    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * @param  User    $user
     * @param  Invoice $invoice
     * @param  array   $params  local, country, pid, hidden
     * @return string
     */
    public function getLink(User $user, Invoice $invoice = null, array $params = array())
    {
        $params = array_merge($params, $this->getDefaultParams());
        $params['marketplace'] = $this->getMarketplace();
        $params['project'] = $this->project->getProjectId();
        $params['v1'] = $user->getV1();
        $params['v2'] = $user->getV2();
        $params['v3'] = $user->getV3();
        $params['email'] = $user->getEmail();
        $params['userip'] = $user->getUserIP();
        $params['phone'] = $user->getPhone();
        if ($invoice) {
            $params['out'] = $invoice->getOut();
            $params['currency'] = $invoice->getCurrency();
        }

        foreach ($params as $key => $value) {
            if (empty($value)) {
                unset($params[$key]);
            }
        }
        $this->checkRequiredParams($params);
        $params['sign'] = $this->generateSign($params);

        return self::BASE_URL.http_build_query($params);
    }

    private function signParamList()
    {
        return array('theme', 'project', 'signparams', 'v0', 'v1', 'v2', 'v3', 'out', 'email', 'currency', 'userip', 'allowSubscription', 'fastcheckout');
    }

    private function generateSign(array $params)
    {
        $keys = $this->signParamList();
        sort($keys);

        $sign = '';
        foreach ($keys as $key) {
            if (isset($params[$key])) {
                $sign .= $key . '=' . $params[$key];
            }
        }

        $key = $this->project->getSecretKey();

        return md5($sign . $key);
    }

    private function checkRequiredParams(array $params)
    {
        $paramsKeys = array_keys($params);
        $diff = array_diff($this->getRequiredParams(), $paramsKeys);
        if ($diff) {
            throw new InvalidArgumentException(sprintf(
                'Following required parameters not passed: %s',
                implode(', ', $diff)
            ));
        }
    }

    abstract public function getMarketplace();

    abstract public function getRequiredParams();

    protected function getDefaultParams()
    {
        return array();
    }
}
