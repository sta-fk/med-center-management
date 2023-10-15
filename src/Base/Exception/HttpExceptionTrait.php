<?php declare(strict_types=1);

namespace App\Base\Exception;

trait HttpExceptionTrait
{
    public function getStatusCode(): int
    {
        return self::STATUS_CODE;
    }

    public function getHeaders(): array
    {
        return [];
    }
}
