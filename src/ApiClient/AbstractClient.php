<?php declare(strict_types=1);

namespace App\ApiClient;

use App\ApiClient\JMSSerializer\SerializationContextFactory;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractClient implements AbstractClientInterface
{
    protected const METHOD_GET   = 'GET';
    protected const METHOD_POST  = 'POST';
    protected const METHOD_PUT   = 'PUT';
    protected const METHOD_PATCH = 'PATCH';

    private SerializationContextFactory $serializationContextFactory;
    private Serializer $serializer;

    public function __construct(
        protected HttpClientInterface $client,
        protected string $baseUrl,
        protected string $secret,
        protected string $url = '',
        protected string $supportedClass = 'array',
    ) {
        $this->serializer = SerializerBuilder::create()
            ->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())
            ->build();
        $this->serializationContextFactory = new SerializationContextFactory();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function get(array|string|null $action = null, array $data = []): array|object
    {
        return $this->request(self::METHOD_GET, $action, $data);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function post(array|string|null $action = null, object|array $data = []): array|object
    {
        return $this->request(self::METHOD_POST, $action, $data);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function patch(array|string|null $action = null, object|array $data = []): array|object
    {
        return $this->request(self::METHOD_PATCH, $action, $data);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function put(array|string|null $action = null, object|array $data = []): array|object
    {
        return $this->request(self::METHOD_PUT, $action, $data);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    protected function request(string $method, array|string|null $action = null, mixed $params = []): array|object
    {
        //prepare url
        $requestUrl = rtrim($this->getBaseUrl() . '/'. $this->url, '/');

        if (!empty($action)) {
            $requestUrl = $requestUrl. '/'. $this->buildUrlParams($action);
        }

        $options = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'secret' => $this->secret,
            ]
        ];

        if (self::METHOD_GET === $method) {
            $options['query'] = $params;
        } elseif (self::METHOD_PUT === $method || self::METHOD_POST === $method || self::METHOD_PATCH === $method) {
            $json = $this->serializer->serialize($params, 'json', $this->serializationContextFactory->create());

            $options['body'] = $json;

            if (!empty($this->auth[0])) {
                $options['auth'] = $this->auth;
            }
        }

        $response = $this->client->request($method, $requestUrl, $options);
        $body = $response->getContent();

        if ($body != '' && $body != 'null' && $body != null) {
            return $this->serializer->deserialize($body, $this->supportedClass, 'json');
        }

        return [];
    }

    protected function buildUrlParams(array|string $params): string
    {
        if (is_string($params)) {
            return trim($params, '/');
        }

        $result = [];

        foreach ($params as $key => $value) {
            if (is_numeric($key)) {
                $result[] = $value;
            } elseif (is_array($value)) {
                $result[] = $this->buildUrlParams($value);
            } else {
                $result[] = $key. '/'. $value;
            }
        }

        return implode('/', $result);
    }

    protected function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
