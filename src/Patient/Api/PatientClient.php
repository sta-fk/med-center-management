<?php declare(strict_types=1);

namespace App\Patient\Api;

use App\ApiClient\AbstractClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class PatientClient extends AbstractClient
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function searchPatient(array $params = [])
    {
        $response = $this->get('persons', $params);

        return $response['data'] ?? null;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getPatientDeclarationById(string $patientId)
    {
        $response = $this->get(sprintf('persons/%s/declaration', $patientId));

        return $response['data'] ?? null;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getPatientInfo(): ?array
    {
        $response = $this->get('persons');

        return $response['data'] ?? null;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getPatientDetails(): array
    {
        $response = $this->get('persons/details');

        return array_merge(
            $response['data'],
            ['id' => $response['id']]
        );
    }
}
