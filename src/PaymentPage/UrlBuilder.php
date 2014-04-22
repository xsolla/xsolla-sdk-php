<?php

namespace Xsolla\SDK\PaymentPage;

use Xsolla\SDK\Project;
use Xsolla\SDK\User;
use Xsolla\SDK\Invoice;

class UrlBuilder
{
    const BASE_URL = 'https://secure.xsolla.com/paystation2/?';
    const SANDBOX_URL = 'https://sandbox-secure.xsolla.com/paystation2/?';
    const SANDBOX_KEY = 'A0B@dO4UR_+74pQ!G2rw*Yez9jM5[xbIHC*pX27J(eoctsIqM';

    protected $project;

    protected $parameters = array();

    protected $immutableParameters = array();

    protected $hiddenParameters = array();

    protected $lockedParameters = array();

    protected $immutableLockedParameters = array(
        'project' => 'project',
        'signparams' => 'signparams',
    );

    protected $defaultLockedParameters = array(
        'theme' => 'theme',
        'project' => 'project',
        'signparams' => 'signparams',
        'v0' => 'v0',
        'v1' => 'v1',
        'v2' => 'v2',
        'v3' => 'v3',
        'out' => 'out',
        'email' => 'email',
        'currency' => 'currency',
        'userip' => 'userip',
        'allowSubscription' => 'allowSubscription',
        'fastcheckout' => 'fastcheckout',
        'id_package' => 'id_package',
    );

    protected $defaultParameters = array();

    public function __construct(Project $project, array $immutableParameters = array())
    {
        $this->project = $project;
        $this->immutableParameters = $immutableParameters;
        $this->clear();
    }

    public function setUser(User $user, $lockForUser = true, $hideFromUser = false)
    {
        $this->setParameter('v1', $user->getV1(), $lockForUser, $hideFromUser);
        $this->setParameter('v2', $user->getV2(), $lockForUser, $hideFromUser);
        $this->setParameter('v3', $user->getV3(), $lockForUser, $hideFromUser);
        $this->setParameter('email', $user->getEmail(), $lockForUser, $hideFromUser);
        $this->setParameter('userip', $user->getUserIP(), $lockForUser, $hideFromUser);
        $this->setParameter('phone', $user->getPhone(), $lockForUser, $hideFromUser);

        return $this;
    }

    public function setInvoice(Invoice $invoice, $lockForUser = true, $hideFromUser = false)
    {
        $this->setParameter('out', $invoice->getVirtualCurrencyAmount(), $lockForUser, $hideFromUser);
        $this->setParameter('currency', $invoice->getCurrency(), $lockForUser, $hideFromUser);
        $this->setParameter('sum', $invoice->getAmount(), $lockForUser, $hideFromUser);

        return $this;
    }

    /**
     * @param  string $locale 2-letter definition is used according to ISO 639-1 standard
     * @return $this
     */
    public function setLocale($locale)
    {
        return $this->setParameter('local', $locale, false, false);
    }

    /**
     * @param  string $country 2-letter definition of the country is used according to ISO 3166-1 alpha-2 standard
     * @return $this
     */
    public function setCountry($country)
    {
        return $this->setParameter('country', $country, false, false);
    }

    /**
     * @param  string $name         Additional parameters are described in documentation http://xsolla.github.io/en/pswidget.html#title4
     * @param  string $value
     * @param  bool   $lockForUser  Denies user to change parameter value on payment page. Also parameter will be hidden on payment page
     * @param  bool   $hideFromUser Hides parameter value on payment page
     * @return $this
     */
    public function setParameter($name, $value, $lockForUser = false, $hideFromUser = false)
    {
        if (!$value) {
            return $this;
        }
        $this->parameters[$name] = $value;
        if ($hideFromUser) {
            $this->hiddenParameters[] = $name;
        }
        if ($lockForUser) {
            $this->lockParameterForUser($name);
        } else {
            $this->unlockParameterForUser($name);
        }

        return $this;
    }

    /**
     * @param  string $name Denies user change parameter value on payment page
     * @return $this
     */
    public function lockParameterForUser($name)
    {
        $this->lockedParameters[$name] = $name;

        return $this;
    }

    /**
     * @param  string $name Allows user to change parameter value on payment page
     * @return $this
     */
    public function unlockParameterForUser($name)
    {
        unset($this->lockedParameters[$name]);

        return $this;
    }

    public function clear()
    {
        $this->parameters = array();
        $this->hiddenParameters = array();
        $this->lockedParameters = $this->defaultLockedParameters;

        return $this;
    }

    public function getUrl($baseUrl = self::BASE_URL)
    {
        $parameters = array_merge($this->parameters, $this->immutableParameters);
        $parameters['project'] = $this->project->getProjectId();

        $hiddenParametersList = $this->getHiddenParametersList();
        if ($hiddenParametersList) {
            $parameters['hidden'] = $hiddenParametersList;
        }

        $lockedParametersList = $this->getLockedParametersList();
        if ($lockedParametersList) {
            $parameters['signparams'] = $lockedParametersList;
        }
        $isSandbox = $baseUrl === self::SANDBOX_URL;
        $parameters['sign'] = $this->generateSign($parameters, $isSandbox);

        return $baseUrl.http_build_query($parameters);
    }

    protected function getLockedParametersList()
    {
        $lockedParameters = $this->getSignParametersSortedKeys();
        if (!array_diff($lockedParameters, $this->defaultLockedParameters) and
            !array_diff($this->defaultLockedParameters, $lockedParameters)
        ) {
            return;
        }

        return $this->implodeParameters($lockedParameters);
    }

    protected function getHiddenParametersList()
    {
        return $this->implodeParameters($this->hiddenParameters);
    }

    protected function implodeParameters(array $parameters)
    {
        if (!$parameters) {
            return;
        }
        $uniqueParameters = array_unique($parameters);

        return implode(',', $uniqueParameters);
    }

    protected function generateSign(array $params, $isSandbox = false)
    {
        $keys = $this->getSignParametersSortedKeys();
        $sign = '';
        foreach ($keys as $key) {
            if (isset($params[$key])) {
                $sign .= $key . '=' . $params[$key];
            }
        }
        $key = $this->project->getSecretKey();
        if ($isSandbox) {
            $key = self::SANDBOX_KEY.$key;
        }

        return md5($sign . $key);
    }

    protected function getSignParametersSortedKeys()
    {
        $parameters = array_merge($this->lockedParameters, $this->immutableLockedParameters);
        $keys = array_unique($parameters);
        sort($keys);

        return $keys;
    }
}
