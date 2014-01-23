<?php

namespace Xsolla\SDK;

use Guzzle\Http\Client;
use Xsolla\SDK\Storage\ProjectInterface;

class Calculator
{
    protected $client;
    protected $project;

    public function __construct(Client $client, ProjectInterface $project)
    {
        $this->client = $client;
        $this->project = $project;
    }

    public function calculateOut($geotypeId, $sum)
    {
        $request = $this->client->get('/calc/out.php',
            array(),
            array(
                'query' => array(
                    'project_id' => $this->project->getProjectId(),
                    'geotype_id' => $geotypeId,
                    'sum' => $sum
                )
            )
        );

        return $request->send()->getBody();
    }

    public function calculateIn($geotypeId, $sum)
    {
        $request = $this->client->get('/calc/inn.php',
            array(),
            array(
                'query' => array(
                    'project_id' => $this->project->getProjectId(),
                    'geotype_id' => $geotypeId,
                    'sum' => $sum
                )
            )
        );

        return $request->send()->getBody();
    }
}
