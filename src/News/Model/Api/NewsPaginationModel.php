<?php declare(strict_types=1);

namespace App\News\Model\Api;

use App\Pagination\Model\AbstractPaginationModel;
use JMS\Serializer\Annotation as JMS;

class NewsPaginationModel extends AbstractPaginationModel
{
    public function __construct(float $totalPages, int $page, iterable $items)
    {
        $this->totalPages = $totalPages;
        $this->page = $page;
        $this->items = $items;
    }

    /**
     * @JMS\VirtualProperty
     * @JMS\Type("array<App\News\Entity\News>")
     */
    public function getItems(): iterable
    {
        return $this->items;
    }
}
