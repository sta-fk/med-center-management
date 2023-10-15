<?php declare(strict_types=1);

namespace App\Appointments\Controller\Api;

use App\Appointments\Exception\RequiredParametersAreMissingException;
use App\Appointments\Manager\AppointmentsManager;
use App\Appointments\Model\Api\AppointmentRequestModel;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;

class PatientAppointmentsController extends AbstractFOSRestController
{
    public function __construct(
        private AppointmentsManager $appointmentsManager,
    ) {}

    /**
     * @Rest\Route("/{id}/appointment", name="appointment.create", methods={"POST"})
     *
     * @OA\Post(
     *     summary="Create appointment"
     * )
     *
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Patient user id"
     * )
     *
     * @OA\RequestBody(
     *     @Model(type=AppointmentRequestModel::class)
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Appointment was created",
     * )
     *
     * @OA\Tag(name="appointment")
     *
     * @Rest\View(statusCode=201)
     */
    public function createAppointment(int $id, AppointmentRequestModel $appointmentRequest)
    {
        $this->appointmentsManager->createAppointment($id, $appointmentRequest);
    }

    /**
     * @Rest\Route("/{id}/appointment/available", name="appointment.available", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get available time for service to employee in day"
     * )
     *
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Patient user id"
     * )
     *
     * @OA\Parameter(
     *     name="service",
     *     in="query",
     *     description="Service id"
     * )
     *
     * @OA\Parameter(
     *     name="employee",
     *     in="query",
     *     description="Employee id"
     * )
     *
     * @OA\Parameter(
     *     name="date",
     *     in="query",
     *     description="Date"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Get available appointments time on day",
     * )
     *
     * @OA\Response(
     *     response=422,
     *     description="Logic violation error",
     * )
     *
     * @OA\Response(
     *     response=409,
     *     description="Patient or employee has appointment on required time",
     * )
     *
     * @OA\Tag(name="appointment")
     *
     * @Rest\View(statusCode=200)
     */
    public function getAvailableTimeOnDay(Request $request, int $id): array
    {
        if (
            $request->get('service')
            && $request->get('employee')
            && $request->get('date')
        ) {
            return $this->appointmentsManager->getAvailableAppointmentsTime(
                $id,
                (int)$request->get('service'),
                (int)$request->get('employee'),
                $request->get('date')
            );
        }

        throw new RequiredParametersAreMissingException();
    }
}
