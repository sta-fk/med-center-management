<?php declare(strict_types=1);

namespace App\ApiClient\JMSSerializer;

use JMS\Serializer\SerializationContext;

class SerializationContextFactory implements SerializationContextFactoryInterface
{
    public function create(): SerializationContext
    {
        return SerializationContext::create()->setSerializeNull(false);
    }
}
