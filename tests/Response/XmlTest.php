<?php


namespace Xsolla\SDK\Tests\Response;

use Xsolla\SDK\Response\Xml;
use Xsolla\SDK\Version;

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

    public function testDisabledVersionHeader()
    {
        $xml = new Xml(false);
        $response = $xml->get(array());
        $this->assertFalse($response->headers->has(Xml::VERSION_HEADER));
    }

    public function testGet()
    {
        $response = $this->xml->get(array('key1' => 'value1', 'key2' => array('key3' => 'value3', 'key4' => 'value4')));
        $expectedXml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<response><key1>value1</key1><key2><key3>value3</key3><key4>value4</key4></key2></response>

XML;
        $actualXml = $response->getContent();

        $this->validateRawXml($actualXml);
        $this->assertEquals($expectedXml, $actualXml);

        $this->assertEquals('text/xml; charset=UTF-8', $response->headers->get('Content-Type'));
        $this->assertEquals(
            'xsolla-sdk-php/'.Version::VERSION.' PHP/'.PHP_VERSION,
            $response->headers->get(Xml::VERSION_HEADER)
        );
    }

    protected function validateRawXml($rawXml)
    {
        $previous = libxml_use_internal_errors(false);
        simplexml_load_string($rawXml);
        libxml_use_internal_errors($previous);
    }
}
 