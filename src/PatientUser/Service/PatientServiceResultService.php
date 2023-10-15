<?php declare(strict_types=1);

namespace App\PatientUser\Service;

use App\Appointments\Repository\AppointmentsRepository;
use App\Catalog\Repository\ServiceRepository;
use App\Catalog\Repository\ServiceResultRepository;
use App\PatientUser\Entity\PatientProfile;
use App\PatientUser\Entity\PatientServiceResult;
use App\PatientUser\Exception\InvalidPatientServiceResultRequestException;
use App\PatientUser\Exception\PatientServiceResultNotFoundException;
use App\PatientUser\Model\Api\Request\PatientServiceResultModel as PatientServiceResultRequest;
use App\PatientUser\Model\Api\Response\PatientServiceResultModel as PatientServiceResultResponse;
use App\PatientUser\Repository\PatientServiceResultRepository;
use Psr\Log\LoggerInterface;

class PatientServiceResultService
{
    public function __construct(
        private ServiceResultRepository $serviceResultRepository,
        private LoggerInterface $patientServiceResultApiLogger,
        private AppointmentsRepository $appointmentsRepository,
        private ServiceRepository $serviceRepository,
        private PatientServiceResultRepository $patientServiceResultRepository,
        private PatientServiceResultModelBuilder $patientServiceResultModelBuilder,
        private PatientServiceResultPdfGenerator $patientServiceResultPdfGenerator,
    ) {}

    /**
     * @throws \Mpdf\MpdfException
     * @throws \Twig\Error\SyntaxError
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function getPatientServiceResultPdf(PatientProfile $patientProfile, string $serviceSlug, string $date): void
    {
        $patientServiceResult = $this->patientServiceResultRepository->getServiceResultByDate(
            $patientProfile->getId(),
            $serviceSlug,
            $date
        );

        if (is_null($patientServiceResult)) {
            throw new PatientServiceResultNotFoundException('Not found results by date ' . $date);
        }

        $pdfData = $this->patientServiceResultModelBuilder->buildPatientServiceResultPdfModel($patientServiceResult);

        $this->patientServiceResultPdfGenerator->generatePatientServiceResultPdf($pdfData);
    }

    /**
     * @return PatientServiceResultResponse[]
     */
    public function getPatientServiceResults(PatientProfile $patientProfile): array
    {
        $results = $this->patientServiceResultRepository->getResultsGroupedByDate($patientProfile->getId());

        return array_map(
            function (PatientServiceResult $result) {
                return $this->patientServiceResultModelBuilder->buildPatientServiceResultModel($result);
            }, $results
        );
    }

    public function createPatientServiceResult(PatientProfile $patientProfile, PatientServiceResultRequest $requestResultModel): PatientServiceResult
    {
        $patientResult = new PatientServiceResult();
        $result = $this->createServiceResult($requestResultModel);

        $patientResult
            ->setService($this->serviceRepository->findOneBy(['id' => $requestResultModel->getServiceId()]))
            ->setDate(new \DateTimeImmutable('now'))
            ->setPatient($patientProfile)
            ->setResult($result);

        if ($requestResultModel->getAppointmentId()) {
            $patientResult->setAppointment(
                $this->appointmentsRepository->findOneBy(['id' => $requestResultModel->getAppointmentId()])
            );
        }

        return $patientResult;
    }

    private function createServiceResult(PatientServiceResultRequest $requestResultModel): array
    {
        $requestResult = $requestResultModel->getResult();
        $resultTemplate = $this->serviceResultRepository->findOneBy(['service' => $requestResultModel->getServiceId()])->getTemplate();

        $result = [];
        for ($i = 0; $i < count($resultTemplate); $i++) {
            if ($resultTemplate[$i]['name'] !== $requestResult[$i]['name']) {
                $this->patientServiceResultApiLogger->error(
                    __METHOD__, [
                        'message' => 'Request result field name not equal template another one',
                        'serviceId' => $requestResultModel->getServiceId(),
                        'requestField' => $requestResult[$i]['name'],
                        'templateField' => $resultTemplate[$i]['name'],
                    ]
                );

                throw new InvalidPatientServiceResultRequestException();
            }

            $result[] = $this->buildObject($requestResult[$i]);
        }

        return $result;
    }

    // todo: validate children
    private function buildObject(array $child): array
    {
        if (isset($child["children"])) {
            return [
                "name" => $child["name"],
                "children" => array_map(
                    [$this, 'buildObject'], $child["children"]
                )
            ];
        }

        return [
            "name" => $child["name"],
            "result" => $child["result"],
            "unit" => $child["unit"],
            "refer" => $child["refer"],
        ];
    }
}
