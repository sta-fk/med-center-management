<?php declare(strict_types=1);

namespace App\Catalog\Model\Api;

use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\Discriminator(
 *     field="type",
 *     map={
 *         "department": "App\Catalog\Model\Api\DepartmentServicesModel",
 *         "serviceGroup": "App\Catalog\Model\Api\ServiceGroupModel",
 *         "service": "App\Catalog\Model\Api\ServiceModel",
 *     },
 *     disabled=true
 * )
 */
abstract class AbstractServiceModel
{
    protected int $id;
    protected string $name;
    protected string $slug;

    abstract public function getType(): string;
}
