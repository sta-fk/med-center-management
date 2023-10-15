<?php declare(strict_types=1);

namespace App\Catalog\Service;

use App\Catalog\Model\Api\DepartmentServicesPaginationModel;
use App\Pagination\Model\AbstractPaginationModel;
use App\Pagination\Service\AbstractPaginationModelBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;

class DepartmentServicesPaginationModelBuilder extends AbstractPaginationModelBuilder
{
    public function buildPaginationModel(PaginationInterface $pagination): AbstractPaginationModel
    {
        return new DepartmentServicesPaginationModel(
            $this->getTotalPages($pagination),
            $pagination->getCurrentPageNumber(),
            $pagination->getItems(),
        );
    }
}
