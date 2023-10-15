<?php declare(strict_types=1);

namespace App\Employee\Api;

use App\ApiClient\AbstractClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class EmployeeClient extends AbstractClient
{
    private const EMPLOYEE_DETAILS_URL_MASK = 'employees/%s';

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getAllEmployees(): ?array
    {
        $response = $this->get('employees');

        return $response['data'] ?? null;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getEmployeeDetailsById(string $id): ?array
    {
        $response = $this->get(sprintf(self::EMPLOYEE_DETAILS_URL_MASK, $id));

        return $response['data'] ?? null;
    }
}
