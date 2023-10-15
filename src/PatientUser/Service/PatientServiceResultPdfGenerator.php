<?php declare(strict_types=1);

namespace App\PatientUser\Service;

use App\PatientUser\Model\PatientServiceResultModel;
use Mpdf\Output\Destination;
use Twig\Environment;

class PatientServiceResultPdfGenerator
{
    public function __construct(
        private Environment $twig,
    ) {}

    /**
     * @throws \Mpdf\MpdfException
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function generatePatientServiceResultPdf(PatientServiceResultModel $data): void
    {
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($this->twig->render('patient_service_result.html.twig', ['data' => $data]));
        $mpdf->Output($data->fileName, Destination::DOWNLOAD);
    }
}
