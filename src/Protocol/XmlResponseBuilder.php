<?php

namespace Xsolla\SDK\Protocol;

use \Symfony\Component\HttpFoundation\Response;
use Xsolla\SDK\Version;

class XmlResponseBuilder
{
    const VERSION_HEADER = 'X-Xsolla-SDK';

    protected $enableVersionHeader;

    public function __construct($enableVersionHeader = true)
    {
        $this->enableVersionHeader = $enableVersionHeader;
    }

    public function get(array $response)
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><response></response>');
        $simpleXml = $this->addChildren($xml, $response);

        $response = new Response($simpleXml->asXML());
        $response->headers->set('Content-Type', 'text/xml; charset=UTF-8');
        if ($this->enableVersionHeader) {
            $response->headers->set(self::VERSION_HEADER, Version::getVersion());
        }

        return $response;
    }

    protected function addChildren(\SimpleXMLElement $element, $children)
    {
        foreach ($children as $key => $value) {
            if (is_array($value)) {
                $child = $element->addChild($key);
                $this->addChildren($child, $value);
            } else {
                $element->addChild($key, $value);
            }
        }

        return $element;
    }
}
