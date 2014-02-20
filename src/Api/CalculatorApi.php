<?php

namespace Xsolla\SDK\Api;

use Guzzle\Http\Client;
use Xsolla\SDK\Project;

/**
 * @link http://xsolla.github.io/en/APIcalc.html
 */
class CalculatorApi
{
    const BASE_URL = 'https://api.xsolla.com';

    protected $client;
    protected $project;

    public function __construct(Client $client, Project $project)
    {
        $this->client = $client;
        $this->client->setBaseUrl(self::BASE_URL);
        $this->project = $project;
    }

    /**
     * @param $geotypeId
     * @param $sum
     * @return \Guzzle\Http\EntityBodyInterface|string
     */
    public function calculateOut($geotypeId, $sum)
    {
        $request = $this->createRequest('/calc/out.php', $geotypeId, $sum);

        return $request->send()->getBody();
    }

    /**
     * @param $geotypeId
     * @param $sum
     * @return \Guzzle\Http\EntityBodyInterface|string
     */
    public function calculateIn($geotypeId, $sum)
    {
        $request = $this->createRequest('/calc/inn.php', $geotypeId, $sum);

        return $request->send()->getBody();
    }

    protected function createRequest($url, $geotypeId, $sum)
    {
        return $this->client->get(
            $url,
            array(),
            array(
                'query' => array(
                    'project_id' => $this->project->getProjectId(),
                    'geotype_id' => $geotypeId,
                    'sum' => $sum
                )
            )
        );
    }
}
