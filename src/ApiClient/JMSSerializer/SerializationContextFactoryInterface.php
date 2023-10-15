<?php declare(strict_types=1);

namespace App\ApiClient\JMSSerializer;

use JMS\Serializer\SerializationContext;

interface SerializationContextFactoryInterface
{
    public function create(): SerializationContext;
}
