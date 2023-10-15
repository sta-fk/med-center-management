<?php declare(strict_types=1);

namespace App\PatientUser\Model\Api\Request\Documents;

use App\PatientUser\Enum\DocumentType;
use JMS\Serializer\Annotation as JMS;
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
 *         enum={2}
 *     )
 * )
 */
class PatientIdCardModel extends PatientDocumentModel
{
    public function __construct(
        /**
         * @Assert\NotBlank
         * @Assert\Regex("/^\d{9}$/", message="api.documents.idcard_number_incorrect")
         */
        protected string $number,

        /**
         * @Assert\NotBlank
         *
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        protected \DateTimeImmutable $expireDate,

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
        return DocumentType::ID_CARD;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getExpireDate(): \DateTimeImmutable
    {
        return $this->expireDate;
    }
}
