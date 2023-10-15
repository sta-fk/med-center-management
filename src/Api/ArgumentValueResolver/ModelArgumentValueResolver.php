<?php declare(strict_types=1);

namespace App\Api\ArgumentValueResolver;

use App\Api\Request\ModelArgumentValueInterface;
use JetBrains\PhpStorm\Pure;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class ModelArgumentValueResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {}

    #[Pure]
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return is_a($argument->getType(), ModelArgumentValueInterface::class, true);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        yield $this->serializer->deserialize($request->getContent(), $argument->getType(), 'json');
    }
}
