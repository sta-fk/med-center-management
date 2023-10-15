<?php declare(strict_types=1);

namespace App\Authorization\Service;

use App\Authorization\Exception\PatientUserNotFoundException;
use App\PatientUser\Entity\PatientUser;
use App\PatientUser\Model\Api\Request\PatientUserModel;
use App\PatientUser\Repository\PatientUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PatientUserRegistrationService
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private CodeGenerator $codeGenerator,
        private MailSender $mailer,
        private EntityManagerInterface $entityManager,
        private PatientUserRepository $patientUserRepository,
        private PatientUserValidator $validator,
    ) {}

    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    public function registerUser(PatientUserModel $patientUserModel): void
    {
        $this->validator->validatePatientUser($patientUserModel);

        $user = new PatientUser();

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $patientUserModel->getPlainPassword()
        );

        $user->setEmail($patientUserModel->getEmail())
            ->setPassword($hashedPassword)
            ->setConfirmationCode($this->codeGenerator->getConfirmationCode());

        $this->validator->validatePatientUser($user);
        $this->patientUserRepository->add($user, true);

        $this->mailer->sendConfirmationMessage($user);
    }

    public function confirmEmail(string $code): void
    {
        /** @var PatientUser $user */
        $user = $this->patientUserRepository->findOneBy(['confirmationCode' => $code]);

        if (is_null($user)) {
            throw new PatientUserNotFoundException();
        }

        $user->setEnabled(true);
        $user->setConfirmationCode(null);

        $this->entityManager->flush();
        $this->entityManager->clear();
    }
}
