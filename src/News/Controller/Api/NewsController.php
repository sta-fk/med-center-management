<?php declare(strict_types=1);

namespace App\News\Controller\Api;

use App\News\Entity\News;
use App\News\Model\Api\NewsPaginationModel;
use App\News\Repository\NewsRepository;
use App\News\Service\NewsPaginationModelBuilder;
use App\Pagination\Model\AbstractPaginationModel;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Knp\Component\Pager\PaginatorInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends AbstractFOSRestController
{
    public function __construct(
        private NewsRepository $newsRepository,
        private PaginatorInterface $paginator,
        private NewsPaginationModelBuilder $newsPaginationModelBuilder,
    ) {}

    /**
     * @Rest\Route("news", name="news.all", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get all news"
     * )
     *
     * @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="Number page",
     *     example="2"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns content",
     *     @OA\JsonContent(
     *      oneOf={
     *          @OA\Schema(
     *              ref=@Model(type=NewsPaginationModel::class)
     *          ),
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(ref=@Model(type=News::class))
     *          ),
     *      })
     * )
     *
     * @OA\Tag(name="news")
     *
     * @Rest\View(statusCode=200)
     */
    public function getAllNewsAction(Request $request): AbstractPaginationModel|array
    {
        $news = $this->newsRepository->findAll();

        if ($request->get('page')) {
            $pagination = $this->paginator->paginate(
                $news,
                (int) $request->get('page'),
                $request->get('limit') ? (int) $request->get('limit') : 6
            );

            return $this->newsPaginationModelBuilder->buildPaginationModel($pagination);
        }

        return $news;
    }
}
