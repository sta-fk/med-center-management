<?php declare(strict_types=1);

namespace App\Appointments\Exception;

use App\Base\Exception\HttpExceptionTrait;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class AppointmentIsUnavailableException extends InvalidArgumentException implements HttpExceptionInterface
{
    use HttpExceptionTrait;

    private const STATUS_CODE = Response::HTTP_CONFLICT;

    protected $message = 'Impossible to make an appointment with this doctor for the required procedure at this time.';
}
