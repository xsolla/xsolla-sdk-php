<?php

namespace Xsolla\SDK\Tests\Protocol;

use Xsolla\SDK\Protocol\XmlResponseBuilder;
use Xsolla\SDK\Version;

class XmlResponseBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var XmlResponseBuilder
     */
    protected $xml;

    public function setUp()
    {
        $this->xml = new XmlResponseBuilder();
    }

    public function testDisabledVersionHeader()
    {
        $xml = new XmlResponseBuilder(false);
        $response = $xml->get(array());
        $this->assertFalse($response->headers->has(XmlResponseBuilder::VERSION_HEADER));
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
            $response->headers->get(XmlResponseBuilder::VERSION_HEADER)
        );
    }

    protected function validateRawXml($rawXml)
    {
        $previous = libxml_use_internal_errors(false);
        simplexml_load_string($rawXml);
        libxml_use_internal_errors($previous);
    }
}
 