<?php

namespace Xsolla\SDK\Tests\Integration\API;

class VirtualCurrencyTest extends AbstractAPITest
{
    public function testGetProjectVirtualCurrencySettings()
    {
        $virtualCurrencySettings = $this->xsollaClient->GetProjectVirtualCurrencySettings(
            array('project_id' => $this->projectId)
        );
    }

    public function testUpdateProjectVirtualCurrencySettings()
    {

    }
}