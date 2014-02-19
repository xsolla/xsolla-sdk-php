<?php

namespace Xsolla\SDK\Widget;

use Xsolla\SDK\Project;
use Xsolla\SDK\User;
use Xsolla\SDK\Invoice;

abstract class Widget
{
    const BASE_URL = 'https://secure.xsolla.com/paystation2/?';

    protected $project;

    protected $parameters = array();

    protected $hiddenParameters = array();

    protected $signedParameters = array();

    protected $defaultSignedParameters = array(
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

    protected $marketplace = 'paystation';

    protected $defaultParameters = array();

    public function __construct(Project $project)
    {
        $this->project = $project;
        $this->clear();
    }

    public function setUser(User $user, $hideFromUser = false, $signed = true)
    {
        $this->setParameter('v1', $user->getV1(), $hideFromUser, $signed);
        $this->setParameter('v2', $user->getV2(), $hideFromUser, $signed);
        $this->setParameter('v3', $user->getV3(), $hideFromUser, $signed);
        $this->setParameter('email', $user->getEmail(), $hideFromUser, $signed);
        $this->setParameter('userip', $user->getUserIP(), $hideFromUser, $signed);
        $this->setParameter('phone', $user->getPhone(), $hideFromUser, $signed);

        return $this;
    }

    public function setInvoice(Invoice $invoice, $hideFromUser = false, $signed = true)
    {
        $this->setParameter('out', $invoice->getOut(), $hideFromUser, $signed);
        $this->setParameter('currency', $invoice->getCurrency(), $hideFromUser, $signed);

        return $this;
    }

    /**
     * @param string $locale 2-letter definition is used according to ISO 639-1 standard
     * @param bool $hideFromUser
     * @param bool $signed
     * @return $this
     */
    public function setLocale($locale, $hideFromUser = false, $signed = false)
    {
        return $this->setParameter('local', $locale, $hideFromUser, $signed);
    }

    /**
     * @param string $country 2-letter definition of the country is used according to ISO 3166-1 alpha-2 standard
     * @param bool $hideFromUser
     * @param bool $signed
     * @return $this
     */
    public function setCountry($country, $hideFromUser = false, $signed = false)
    {
        return $this->setParameter('country', $country, $hideFromUser, $signed);
    }

    /**
     * @param string $name Additional parameters described in documentation http://xsolla.github.io/en/pswidget.html#title4
     * @param string $value
     * @param bool $hideFromUser Hide parameter value on payment page
     * @param bool $signed Deny user change parameter value on payment page
     * @return $this
     */
    public function setParameter($name, $value, $hideFromUser = false, $signed = false)
    {
        if (!$value) {
            return $this;
        }
        $this->parameters[$name] = $value;
        if ($hideFromUser) {
            $this->hiddenParameters[] = $name;
        }
        if ($signed) {
            $this->addToSignedParameters($name);
        } else {
            $this->removeFromSignedParameters($name);
        }

        return $this;
    }

    /**
     * @param string $name Allow user change parameter value on payment page
     * @return $this
     */
    public function addToSignedParameters($name)
    {
        $this->signedParameters[$name] = $name;
        return $this;
    }

    /**
     * @param string $name Deny user change parameter value on payment page
     * @return $this
     */
    public function removeFromSignedParameters($name)
    {
        unset($this->signedParameters[$name]);
        return $this;
    }

    public function clear()
    {
        $this->parameters = array();
        $this->hiddenParameters = array();
        $this->signedParameters = $this->defaultSignedParameters;

        return $this;
    }

    /**
     * Allow user change ALL parameters values on payment page
     */
    public function clearSignedParameters()
    {
        $this->signedParameters = array();

        return $this;
    }

    public function getLink()
    {
        $parameters = array_merge($this->parameters, $this->defaultParameters);
        $parameters['marketplace'] = $this->marketplace;
        $parameters['project'] = $this->project->getProjectId();

        $hiddenParametersList = $this->getHiddenParametersList();
        if ($hiddenParametersList) {
            $parameters['hidden'] = $hiddenParametersList;
        }

        $signedParametersList = $this->getSignedParametersList();
        if ($signedParametersList) {
            $parameters['signparams'] = $signedParametersList;
        }
        $parameters['sign'] = $this->generateSign($parameters);

        return self::BASE_URL.http_build_query($parameters);
    }

    protected function getSignedParametersList()
    {
        $signedParameters = $this->getSignParametersSortedKeys();
        if (!array_diff($signedParameters, $this->defaultSignedParameters) and
            !array_diff($this->defaultSignedParameters, $signedParameters)
        ) {
            return;
        }
        return $this->implodeParameters($signedParameters);
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

    protected function generateSign(array $params)
    {
        $keys = $this->getSignParametersSortedKeys();
        $sign = '';
        foreach ($keys as $key) {
            if (isset($params[$key])) {
                $sign .= $key . '=' . $params[$key];
            }
        }
        $key = $this->project->getSecretKey();

        return md5($sign . $key);
    }

    protected function getSignParametersSortedKeys()
    {
        $parameters = $this->signedParameters;
        $parameters['project'] = 'project';
        $parameters['signparams'] = 'signparams';
        $keys = array_unique($parameters);
        sort($keys);

        return $keys;
    }
}
