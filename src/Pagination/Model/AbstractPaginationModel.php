<?php declare(strict_types=1);

namespace App\Pagination\Model;

abstract class AbstractPaginationModel
{
    protected float $totalPages;
    protected int $page;
    protected iterable $items;

    abstract public function getItems(): iterable;
}
