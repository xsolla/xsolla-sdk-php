<?php

namespace Xsolla\SDK\Widget;

use Xsolla\SDK\Storage\ProjectInterface;

class Paystation implements WidgetInterface
{
    protected $project;
    public function __construct(ProjectInterface $project) {
        $this->project = $project;
    }
} 