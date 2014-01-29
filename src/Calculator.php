<?php

namespace Xsolla\SDK;

use Guzzle\Http\Client;
use Xsolla\SDK\Project;

/**
 * @link http://xsolla.github.io/en/APIcalc.html
 */
class Calculator
{
    protected $client;
    protected $project;

    public function __construct(Client $client, Project $project)
    {
        $this->client = $client;
        $this->project = $project;
    }

    public function calculateOut($geotypeId, $sum)
    {
        $request = $this->createRequest('/calc/out.php', $geotypeId, $sum);

        return $request->send()->getBody();
    }

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
