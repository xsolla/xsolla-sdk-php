<?php

namespace Xsolla\SDK\Response;


class Xml
{
    public function get(array $response)
    {
        $responseXml = new \SimpleXMLElement('<response></response>');
        foreach($response as $key => $value) {
            $responseXml->addChild($key, $value);
        }

        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->setContent($responseXml->asXML());
        return $response;
    }
}