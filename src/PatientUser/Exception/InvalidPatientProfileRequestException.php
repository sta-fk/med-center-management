<?php declare(strict_types=1);

namespace App\PatientUser\Exception;

use App\Base\Exception\HttpExceptionTrait;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class InvalidPatientProfileRequestException extends InvalidArgumentException implements HttpExceptionInterface
{
    use HttpExceptionTrait;

    private const STATUS_CODE = 422;

    protected $message = 'Request is invalid, check request data';
}
