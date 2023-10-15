<?php declare(strict_types=1);

namespace App\Appointments\Exception;

use App\Base\Exception\HttpExceptionTrait;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class InvalidRequiredHoursException extends InvalidArgumentException implements HttpExceptionInterface
{
    use HttpExceptionTrait;

    private const STATUS_CODE = Response::HTTP_UNPROCESSABLE_ENTITY;

    protected $message = 'This time has passed';
}
