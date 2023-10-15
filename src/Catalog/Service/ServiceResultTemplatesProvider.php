<?php declare(strict_types=1);

namespace App\Catalog\Service;

use App\Catalog\Exception\ServiceResultNotFoundException;
use App\Catalog\Model\Api\ServiceResultTemplateModel;
use App\Catalog\Repository\ServiceResultRepository;

class ServiceResultTemplatesProvider
{
    public function __construct(
        private ServiceResultRepository $serviceResultRepository,
    ) {}

    /**
     * @throws ServiceResultNotFoundException
     */
    public function provideTemplates(int $serviceId): array
    {
        if (is_null($serviceResultTemplate = $this->serviceResultRepository->findOneBy(['service' => $serviceId]))) {
            throw new ServiceResultNotFoundException('Template for service with id '. $serviceId .' not found');
        }

        $template = $serviceResultTemplate->getTemplate();

        return array_map(
            function ($item) {
                return new ServiceResultTemplateModel(
                    $item['name'],
                    $item['result'] ?? null,
                    $item['unit'] ?? null,
                    $item['refer'] ?? null,
                    isset($item['children']) ? $this->buildChildren($item['children']) : null,
                );
            }, $template
        );
    }

    private function buildChildren(array $child): array
    {
        return array_map(
            function ($item) {
                return new ServiceResultTemplateModel(
                    $item['name'],
                    $item['result'] ?? null,
                    $item['unit'] ?? null,
                    $item['refer'] ?? null,
                    isset($item['children']) ? $this->buildChildren($item['children']) : null,
                );
            }, $child
        );
    }
}
