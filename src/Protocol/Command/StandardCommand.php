<?php
namespace Xsolla\SDK\Protocol\Command;

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\User;

abstract class StandardCommand extends Command
{
    const CODE_TEMPORARY_ERROR = 1;
    const CODE_INVALID_ORDER_DETAILS = 2;
    const CODE_INVALID_SIGN = 3;
    const CODE_INVALID_REQUEST = 4;
    const CODE_FATAL_ERROR = 7;

    const COMMENT_FIELD_NAME = 'comment';

    public function createUser(Request $request)
    {
        return new User(
            $request->query->get('v1'),
            $request->query->get('v2'),
            $request->query->get('v3')
        );
    }

    public function getCommentFieldName()
    {
        return self::COMMENT_FIELD_NAME;
    }

    public function getInvalidSignResponseCode()
    {
        return self::CODE_INVALID_SIGN;
    }

    public function getInvalidRequestResponseCode()
    {
        return self::CODE_INVALID_REQUEST;
    }

    public function getUnprocessableRequestResponseCode()
    {
        return self::CODE_FATAL_ERROR;
    }

    public function getTemporaryServerErrorResponseCode()
    {
        return self::CODE_TEMPORARY_ERROR;
    }
}
