<?php declare(strict_types=1);

namespace App\News\Service;

use App\News\Model\Api\NewsPaginationModel;
use App\Pagination\Model\AbstractPaginationModel;
use App\Pagination\Service\AbstractPaginationModelBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;

class NewsPaginationModelBuilder extends AbstractPaginationModelBuilder
{
    public function buildPaginationModel(PaginationInterface $pagination): AbstractPaginationModel
    {
        return new NewsPaginationModel(
            $this->getTotalPages($pagination),
            $pagination->getCurrentPageNumber(),
            $pagination->getItems(),
        );
    }
}
