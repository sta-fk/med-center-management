<?php

namespace App\PatientUser\Exception;

use App\Base\Exception\HttpExceptionTrait;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class PatientServiceResultNotFoundException extends InvalidArgumentException implements HttpExceptionInterface
{
    use HttpExceptionTrait;

    private const STATUS_CODE = 404;

    protected $message = 'Required result not found';
}
