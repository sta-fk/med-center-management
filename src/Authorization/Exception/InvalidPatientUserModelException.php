<?php declare(strict_types=1);

namespace App\Authorization\Exception;

use App\Base\Exception\HttpExceptionTrait;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class InvalidPatientUserModelException extends InvalidArgumentException implements HttpExceptionInterface
{
    use HttpExceptionTrait;

    private const STATUS_CODE = Response::HTTP_UNPROCESSABLE_ENTITY;

    protected $message = 'Invalid patient user model';
}
