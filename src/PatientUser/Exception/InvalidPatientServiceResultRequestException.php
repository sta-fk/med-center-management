<?php

namespace App\PatientUser\Exception;

use App\Base\Exception\HttpExceptionTrait;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class InvalidPatientServiceResultRequestException extends InvalidArgumentException implements HttpExceptionInterface
{
    use HttpExceptionTrait;

    private const STATUS_CODE = 422;

    protected $message = 'Request result not equal to template';
}
