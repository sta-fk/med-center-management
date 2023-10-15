<?php

namespace App\Patient\Exception;

use App\Base\Exception\HttpExceptionTrait;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class InvalidDeclarationException extends InvalidArgumentException implements HttpExceptionInterface
{
    use HttpExceptionTrait;

    private const STATUS_CODE = Response::HTTP_UNPROCESSABLE_ENTITY;

    protected $message = 'Patient declaration not verify in Ehealth. Contact with Ehealth portal';
}
