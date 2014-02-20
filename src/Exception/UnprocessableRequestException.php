<?php

namespace Xsolla\SDK\Exception;

/**
 * If exception is thrown, fatal error will be returned to xsolla and request will be marked as 'error' and will not be repeated
 */
class UnprocessableRequestException extends Exception
{

}
