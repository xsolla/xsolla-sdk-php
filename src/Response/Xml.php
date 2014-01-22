<?php

namespace Xsolla\SDK\Response;


class Xml
{
    public function get(array $response)
    {
        $responseXml = $this->addChildren(new \SimpleXMLElement('<response></response>'), $response);

        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->setContent($responseXml->asXML());
        $sdkVersion = 'php-sdk/0.1; php/' . phpversion();
        $response->headers->set('X-Xsolla-SDK', $sdkVersion);
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