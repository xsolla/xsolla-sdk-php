<?php


namespace Xsolla\SDK\Tests\Response;


use Xsolla\SDK\Response\Xml;

class XmlTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Xml
     */
    protected $xml;
    public function setUp()
    {
        $this->xml = new Xml();
    }

    public function testGetSimple() {
        $response = $this->xml->get(array('key' => 'value'));
        $xml = <<<XML
<?xml version="1.0"?>
<response><key>value</key></response>

XML;

        $this->assertEquals($xml, $response->getContent());
    }

    public function testGet() {
        $response = $this->xml->get(array('key1' => 'value1', 'key2' => array('key3' => 'value3', 'key4' => 'value4')));
        $xml = <<<XML
<?xml version="1.0"?>
<response><key1>value1</key1><key2><key3>value3</key3><key4>value4</key4></key2></response>

XML;

        $this->assertEquals($xml, $response->getContent());
    }
}
 