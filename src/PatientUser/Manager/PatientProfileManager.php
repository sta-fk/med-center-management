<?php declare(strict_types=1);

namespace App\PatientUser\Manager;

use App\PatientUser\Exception\PatientProfileExistsException;
use App\PatientUser\Model\Api\Request\PatientProfileModel;
use App\PatientUser\Repository\PatientProfileRepository;
use App\PatientUser\Service\PatientProfileService;
use App\PatientUser\Service\PatientProfileModelValidator;

class PatientProfileManager
{
    public function __construct(
        private PatientProfileModelValidator $profileModelValidator,
        private PatientProfileRepository $profileRepository,
        private PatientProfileService $patientProfileService,
    ) {}

    public function create(PatientProfileModel $profileModel, int $userId): void
    {
        if (!is_null($this->profileRepository->findOneBy(['user' => $userId]))) {
            throw new PatientProfileExistsException();
        }

        $this->profileModelValidator->validate($profileModel);

        $profile = $this->patientProfileService->createProfile($profileModel, $userId);

        $this->profileRepository->add($profile, true);
    }
}
