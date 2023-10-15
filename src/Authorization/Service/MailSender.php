<?php declare(strict_types=1);

namespace App\Authorization\Service;

use App\Appointments\Entity\Appointments;
use App\PatientUser\Entity\PatientProfile;
use App\PatientUser\Entity\PatientUser;
use Symfony\Component\Mailer\MailerInterface as SymfonyMailer;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class MailSender
{
    public function __construct(
        private SymfonyMailer $mailer,
        private Environment $twig,
    ) {}

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendConfirmationMessage(PatientUser $user): void
    {
        $messageBody = $this->twig->render('confirmation.html.twig', [
            'user' => $user
        ]);

        $message = new Email();
        $message
            ->subject('Підтвердження реєстрації!')
            ->to($user->getEmail())
            ->html($messageBody);

        $this->mailer->send($message);
    }

    /**
     * @param Appointments[] $appointments
     *
     * @throws \Twig\Error\SyntaxError
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function sendAppointmentNotification(PatientProfile $profile, array $appointments): void
    {
        $user = $profile->getUser();

        $messageBody = $this->twig->render('appointment_email_notification.html.twig', ['patient' => $profile, 'appointments' => $appointments]);

        $message = new Email();
        $message
            ->subject('Нагадування від клініки NoName!')
            ->to($user->getEmail())
            ->html($messageBody);

        $this->mailer->send($message);
    }
}
