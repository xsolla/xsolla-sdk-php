<?php

namespace Xsolla\SDK\Exception;

/**
 * If exception thrown, fatal error will be returned to xsolla and request will be marked as 'error' and not be repeated
 */
class UnprocessableRequestException extends Exception
{

}
