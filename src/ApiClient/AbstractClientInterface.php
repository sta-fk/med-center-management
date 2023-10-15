<?php declare(strict_types=1);

namespace App\ApiClient;

interface AbstractClientInterface
{
    public function get(array|string|null $action = null, array $data = []): mixed;
    public function post(array|string|null $action = null, array $data = []): mixed;
    public function patch(array|string|null $action = null, array $data = []): mixed;
    public function put(array|string|null $action = null, array $data = []): mixed;
}
