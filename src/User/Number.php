<?php

namespace Xsolla\SDK\User;


use Xsolla\SDK\Storage\ProjectInterface;
use Xsolla\SDK\User;

class Number
{
    /**
     * @var ProjectInterface
     */
    protected $project;

    public function __construct(ProjectInterface $project)
    {
        $this->project = $project;
    }

    public function getNumber(User $user)
    {

    }
} 