<?php

namespace Xsolla\SDK\Api;

use Guzzle\Http\Client;
use Xsolla\SDK\Exception\InternalServerException;
use Xsolla\SDK\Exception\InvalidArgumentException;
use Xsolla\SDK\Project;
use Xsolla\SDK\User;

/**
 * @link http://xsolla.github.io/en/apixsolla.html
 */
class NumberApi
{
    protected $project;

    protected $client;

    public function __construct(Client $client, Project $project)
    {
        $this->client = $client;
        $this->project = $project;
    }

    /**
     * @param  User $user
     * @return int
     * @throws \RuntimeException
     */
    public function getNumber(User $user)
    {
        $request = $this->client->get(
            '/xsolla_number.php',
            array(),
            array(
                'query' => array(
                    'project' => $this->project->getProjectId(),
                    'v1' => $user->getV1(),
                    'v2' => $user->getV2(),
                    'v3' => $user->getV3(),
                    'email' => $user->getEmail(),
                    'format' => 'json'
                )
            )
        );

        $response = $request->send()->json();
        if ($response['result'] == 0) {
            return $response['number'];
        } elseif (in_array($response['result'], array(10, 11))) {
            throw new InternalServerException($response['description'], $response['result']);
        } else {
            throw new InvalidArgumentException($response['description'], $response['result']);
        }
    }
}
