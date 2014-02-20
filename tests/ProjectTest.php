<?php
namespace Xsolla\SDK\tests;

use Xsolla\SDK\Project;

class ProjectTest extends \PHPUnit_Framework_TestCase
{
    const PROJECT_ID = 1234;
    const SECRET_KEY = 'key';

    public function testGetters()
    {
        $project = new Project(self::PROJECT_ID, self::SECRET_KEY);
        $this->assertSame(self::PROJECT_ID, $project->getProjectId());
        $this->assertSame(self::SECRET_KEY, $project->getSecretKey());
    }
}
