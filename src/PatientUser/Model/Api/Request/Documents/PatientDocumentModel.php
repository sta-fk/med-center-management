<?php declare(strict_types=1);

namespace App\PatientUser\Model\Api\Request\Documents;

use JMS\Serializer\Annotation as JMS;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @JMS\Discriminator(
 *     field="type",
 *     map={
 *         1: "App\PatientUser\Model\Api\Request\Documents\PatientPassportModel",
 *         2: "App\PatientUser\Model\Api\Request\Documents\PatientIdCardModel"
 *     }
 * )
 *
 * @OA\Schema(
 *     oneOf={
 *         @OA\Schema(ref=@Model(type=PatientPassportModel::class)),
 *         @OA\Schema(ref=@Model(type=PatientIdCardModel::class))
 *     }
 * )
 */
abstract class PatientDocumentModel
{
    protected string $number;

    /**
     * @Assert\NotBlank
     *
     * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
     */
    protected \DateTimeImmutable $issueDate;

    /**
     * @Assert\NotBlank
     * @Assert\Length(min="2", max="255")
     */
    protected string $issuePlace;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^\d{10}$/"), message="api.documents.inn_incorrect")
     */
    protected string $inn;

    /**
     * @Assert\Type("bool")
     */
    protected bool $gender;

    abstract public function getType(): int;

    public function getIssueDate(): \DateTimeImmutable
    {
        return $this->issueDate;
    }

    public function getIssuePlace(): string
    {
        return $this->issuePlace;
    }

    public function getInn(): string
    {
        return $this->inn;
    }

    public function getGender(): bool
    {
        return $this->gender;
    }
}
