<?php

namespace Xsolla\SDK\Api;

use Guzzle\Http\Client;
use Xsolla\SDK\Project;

/**
 * @link http://xsolla.github.io/en/APIcalc.html
 */
class CalculatorApi
{
    protected $client;

    protected $project;

    public function __construct(Client $client, Project $project)
    {
        $this->client = $client;
        $this->project = $project;
    }

    /**
     * @param int $geotypeId payment system ID
     * @param float $amount
     * @return string
     */
    public function calculateVirtualCurrencyAmount($geotypeId, $amount)
    {
        $request = $this->createRequest('/calc/out.php', $geotypeId, $amount);

        return $request->send()->getBody(true);
    }

    /**
     * @param int $geotypeId payment system ID
     * @param float $virtualCurrencyAmount
     * @return string
     */
    public function calculateAmount($geotypeId, $virtualCurrencyAmount)
    {
        $request = $this->createRequest('/calc/inn.php', $geotypeId, $virtualCurrencyAmount);

        return $request->send()->getBody(true);
    }

    protected function createRequest($url, $geotypeId, $amount)
    {
        return $this->client->get(
            $url,
            array(),
            array(
                'query' => array(
                    'project_id' => $this->project->getProjectId(),
                    'geotype_id' => $geotypeId,
                    'sum' => $amount
                )
            )
        );
    }
}
