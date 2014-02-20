<?php

namespace Xsolla\SDK\Widget;

use Xsolla\SDK\Project;

/**
 * @link http://xsolla.github.io/en/directpayment.html
 */
class Directpayment extends Widget
{
    protected $marketplace = 'landing';

    protected $pid;

    /**
     * @param Project $project
     * @param int $pid payment system ID
     */
    public function __construct(Project $project, $pid)
    {
        parent::__construct($project);
        $this->pid = $pid;
    }

    public function getLink()
    {
        $this->setParameter('pid', $this->pid);
        return parent::getLink();
    }
}
