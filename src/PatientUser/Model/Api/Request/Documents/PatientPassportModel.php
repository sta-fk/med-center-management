<?php declare(strict_types=1);

namespace App\PatientUser\Model\Api\Request\Documents;

use App\PatientUser\Enum\DocumentType;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @OA\Schema(
 *     allOf={
 *         @OA\Schema(ref=@Model(type=PatientDocumentModel::class))
 *     },
 *     @OA\Property(
 *         property="type",
 *         type="integer",
 *         enum={1}
 *     )
 * )
 */
class PatientPassportModel extends PatientDocumentModel
{
    public function __construct(
        /**
         * @Assert\NotBlank
         * @Assert\Regex("/^[ҐЄІЇЬЮЯА-Щ]{2}$/u", message="api.documents.passport_series_incorrect")
         */
        protected string $range,

        /**
         * @Assert\NotBlank
         * @Assert\Regex("/^\d{6}$/", message="api.documents.passport_number_incorrect")
         */
        protected string $number,

        $issueDate,
        $issuePlace,
        $inn,
    ) {
        $this->issueDate = $issueDate;
        $this->issuePlace = $issuePlace;
        $this->inn = $inn;
    }

    public function getType(): int
    {
        return DocumentType::PASSPORT;
    }

    public function getRange(): string
    {
        return $this->range;
    }

    public function getNumber(): string
    {
        return $this->number;
    }
}
