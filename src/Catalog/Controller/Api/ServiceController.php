<?php declare(strict_types=1);

namespace App\Catalog\Controller\Api;

use App\Appointments\Exception\ServiceNotFoundException;
use App\Catalog\Entity\ServiceResult;
use App\Catalog\Exception\ServiceResultNotFoundException;
use App\Catalog\Model\Api\ServiceResultTemplateModel;
use App\Catalog\Repository\ServiceRepository;
use App\Catalog\Repository\ServiceResultRepository;
use App\Catalog\Service\ServiceResultTemplatesProvider;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ServiceController extends AbstractFOSRestController
{
    public function __construct(
        private ServiceResultRepository $serviceResultRepository,
        private ServiceRepository $serviceRepository,
        private ServiceResultTemplatesProvider $resultTemplatesProvider,
    ) {}

    /**
     * @Rest\Route("/service/{id}/template", name="service.create_template", methods={"POST"})
     *
     * @OA\Post(
     *     summary="Create service result template"
     * )
     *
     * @ParamConverter("template", class="array", converter="fos_rest.request_body")
     *
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Service id",
     *     example="26"
     * )
     *
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref=@Model(type=ServiceResultTemplateModel::class))
     *      )
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Template creation was successfull"
     * )
     *
     * @OA\Tag(name="service")
     *
     * @Rest\View(statusCode=201)
     */
    public function createResultTemplateAction(int $id, array $template)
    {
        if (is_null($service = $this->serviceRepository->findOneBy(['id' => $id]))) {
            throw new ServiceNotFoundException('Service with id '. $id .' not found');
        }

        $templateResult = new ServiceResult();
        $templateResult->setService($service);
        $templateResult->setTemplate($template);

        $this->serviceResultRepository->add($templateResult, true);
    }

    /**
     * @Rest\Route("/service/{id}/template", name="service.update_template", methods={"PATCH"})
     *
     * @OA\Patch(
     *     summary="Update service result template"
     * )
     *
     * @ParamConverter("template", class="array", converter="fos_rest.request_body")
     *
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Service id",
     *     example="26"
     * )
     *
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref=@Model(type=ServiceResultTemplateModel::class))
     *      )
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Template updating was successfull"
     * )
     *
     * @OA\Tag(name="service")
     *
     * @Rest\View(statusCode=200)
     *
     * @throws ServiceResultNotFoundException
     */
    public function updateResultTemplateAction(int $id, array $template)
    {
        if (is_null($this->serviceRepository->findOneBy(['id' => $id]))) {
            throw new ServiceNotFoundException('Service with id '. $id .' not found');
        }

        if (is_null($serviceResult = $this->serviceResultRepository->findOneBy(['service' => $id]))) {
            throw new ServiceResultNotFoundException('Template for service with id '. $id .' not found');
        }

        $serviceResult->setTemplate($template);

        $this->serviceResultRepository->add($serviceResult, true);
    }

    /**
     * @Rest\Route("/service/{id}/template", name="service.template", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get service result template by service id"
     * )
     *
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Service id",
     *     example="26"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Return result template",
     *     @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref=@Model(type=ServiceResultTemplateModel::class))
     *      )
     * )
     *
     * @OA\Response(
     *     response=404,
     *     description="Service not found"
     * )
     *
     * @OA\Tag(name="service")
     *
     * @Rest\View(statusCode=200)
     *
     * @throws ServiceResultNotFoundException
     */
    public function getResultTemplateAction(int $id): array
    {
        if (is_null($this->serviceRepository->findOneBy(['id' => $id]))) {
            throw new ServiceNotFoundException('Service with id '. $id .' not found');
        }

        return $this->resultTemplatesProvider->provideTemplates($id);
    }
}
