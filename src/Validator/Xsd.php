<?php
namespace Xsolla\SDK\Validator;

use Xsolla\SDK\Exception\InvalidResponseException;

class Xsd
{
    public function check($response, $schemaFilename)
    {
        if (!is_readable($schemaFilename)) {
            throw new InvalidResponseException("Schema file: $schemaFilename is not readable.");
        }else{
            $internalErrors = libxml_use_internal_errors();
            libxml_use_internal_errors(true);

            $dom = new \DOMDocument;
            if (false === $dom->loadXML($response)) {
                throw new InvalidResponseException("Wrong format xml");
            }

            if (false === @$dom->schemaValidate($schemaFilename)) {
                throw new InvalidResponseException("Wrong schema xml");
            }

            libxml_use_internal_errors($internalErrors);
        }

        return true;
    }
}