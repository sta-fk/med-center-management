<?php declare(strict_types=1);

namespace App\Appointments\Exception;

use App\Base\Exception\HttpExceptionTrait;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ServiceIsResearchException extends InvalidArgumentException implements HttpExceptionInterface
{
    use HttpExceptionTrait;

    private const STATUS_CODE = Response::HTTP_UNPROCESSABLE_ENTITY;

    protected $message = 'Service is research, it doesn\'t need an appointment';
}
