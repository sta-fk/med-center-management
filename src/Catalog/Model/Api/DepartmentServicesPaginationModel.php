<?php declare(strict_types=1);

namespace App\Catalog\Model\Api;

use App\Pagination\Model\AbstractPaginationModel;
use JMS\Serializer\Annotation as JMS;

class DepartmentServicesPaginationModel extends AbstractPaginationModel
{
    public function __construct(float $totalPages, int $page, iterable $items)
    {
        $this->totalPages = $totalPages;
        $this->page = $page;
        $this->items = $items;
    }

    /**
     * @JMS\VirtualProperty
     * @JMS\Type("array<App\Catalog\Model\Api\DepartmentServicesModel>")
     */
    public function getItems(): iterable
    {
        return $this->items;
    }
}
