<?php

namespace Xsolla\SDK\Validator;

class Xsd
{
    public function check($response, $schemaFilename)
    {
        if (!is_readable($schemaFilename)) {
            throw new \InvalidArgumentException("Schema file: $schemaFilename is not readable.");
        }

        $dom = new \DOMDocument;
        if (false === $dom->loadXML($response)) {
            $this->throwInvalidResponseException();
        }

        if (false === $dom->schemaValidate($schemaFilename)) {
                $this->throwInvalidResponseException();
        }

        return true;
    }
}