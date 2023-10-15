<?php declare(strict_types=1);

namespace App\Employee\Model\Api\Collection;

use App\Employee\Model\Api\EducationModel;
use Doctrine\Common\Collections\ArrayCollection;

class EducationModelCollection
{
    /**
     * @var EducationModel[]|ArrayCollection
     */
    private ArrayCollection|array $educations;

    public function __construct()
    {
        $this->educations = new ArrayCollection();
    }

    public function addEducation(EducationModel $educationModel): void
    {
        if (!$this->educations->contains($educationModel)) {
            $this->educations->add($educationModel);
        }
    }

    public function getEducations(): ArrayCollection|array
    {
        return $this->educations;
    }
}
