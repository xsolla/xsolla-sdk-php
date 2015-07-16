<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class VirtualCurrencyTest extends AbstractAPITest
{
    public function testUpdateProjectVirtualCurrencySettings()
    {
        $this->xsollaClient->UpdateProjectVirtualCurrencySettings(array(
            'request' => array(
                'vc_name' => array(
                    'en' => 'name',
                ),
                'base' => array(
                    'USD' => 1,
                ),
                'min' => 0,
                'max' => 0,
                'default_currency' => 'USD',
            ),
            'project_id' => $this->projectId,
        ));
    }

    public function testGetProjectVirtualCurrencySettings()
    {
        $this->xsollaClient->GetProjectVirtualCurrencySettings(array('project_id' => $this->projectId));
    }
}