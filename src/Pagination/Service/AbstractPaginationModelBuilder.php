<?php declare(strict_types=1);

namespace App\Pagination\Service;

use App\Pagination\Model\AbstractPaginationModel;
use Knp\Component\Pager\Pagination\PaginationInterface;

abstract class AbstractPaginationModelBuilder
{
    abstract public function buildPaginationModel(PaginationInterface $pagination): AbstractPaginationModel;

    public function getTotalPages(PaginationInterface $pagination): float
    {
        return ceil($pagination->getTotalItemCount()/$pagination->getItemNumberPerPage());
    }
}
