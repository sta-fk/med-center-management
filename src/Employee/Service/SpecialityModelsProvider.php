<?php declare(strict_types=1);

namespace App\Employee\Service;

use App\Employee\Entity\EmployeeSpeciality;
use App\Employee\Model\Api\Collection\SpecialityModelCollection;
use App\Employee\Model\Api\SpecialityModel;

class SpecialityModelsProvider
{
    /**
     * @param EmployeeSpeciality[] $employeeContacts
     */
    public function getEmployeeSpecialityModels(array $employeeContacts): SpecialityModelCollection
    {
        $specialityCollection = new SpecialityModelCollection();

        array_map(
            function (EmployeeSpeciality $speciality) use ($specialityCollection){
                $specialityCollection->addSpeciality($this->buildEmployeeSpecialityModel($speciality));
            }, $employeeContacts
        );

        return $specialityCollection;
    }

    public function buildEmployeeSpecialityModel(EmployeeSpeciality $speciality): SpecialityModel
    {
        return new SpecialityModel(
            $speciality->getSpeciality(),
            $speciality->getLevel(),
            $speciality->getAttestationDate(),
            $speciality->getValidTo(),
            $speciality->isSpecialityOfficio(),
        );
    }

}
