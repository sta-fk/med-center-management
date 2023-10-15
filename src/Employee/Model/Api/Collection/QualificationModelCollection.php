<?php declare(strict_types=1);

namespace App\Employee\Model\Api\Collection;

use App\Employee\Model\Api\QualificationModel;
use Doctrine\Common\Collections\ArrayCollection;

class QualificationModelCollection
{
    /**
     * @var QualificationModel[]|ArrayCollection
     */
    private ArrayCollection|array $qualifications;

    public function __construct()
    {
        $this->qualifications = new ArrayCollection();
    }

    public function addQualification(QualificationModel $qualificationModel): void
    {
        if (!$this->qualifications->contains($qualificationModel)) {
            $this->qualifications->add($qualificationModel);
        }
    }

    public function getQualifications(): ArrayCollection|array
    {
        return $this->qualifications;
    }
}
