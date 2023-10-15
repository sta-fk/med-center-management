<?php declare(strict_types=1);

namespace App\Employee\Model\Api\Collection;

use App\Employee\Model\Api\SpecialityModel;
use Doctrine\Common\Collections\ArrayCollection;

class SpecialityModelCollection
{
    /**
     * @var SpecialityModel[]|ArrayCollection
     */
    private ArrayCollection|array $specialities;

    public function __construct()
    {
        $this->specialities = new ArrayCollection();
    }

    public function addSpeciality(SpecialityModel $specialityModel): void
    {
        if (!$this->specialities->contains($specialityModel)) {
            $this->specialities->add($specialityModel);
        }
    }

    public function getSpecialities(): ArrayCollection|array
    {
        return $this->specialities;
    }
}
