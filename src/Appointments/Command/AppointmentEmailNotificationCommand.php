<?php declare(strict_types=1);

namespace App\Appointments\Command;

use App\Appointments\Entity\Appointments;
use App\Authorization\Service\MailSender;
use App\PatientUser\Repository\PatientProfileRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppointmentEmailNotificationCommand extends Command
{
    protected static $defaultName = 'appointments:email_notification';

    public function __construct(
        private PatientProfileRepository $patientProfileRepository,
        private MailSender $mailSender,
        private LoggerInterface $appointmentEmailCronLogger,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $patients = $this->patientProfileRepository->getTomorrowAppointmentsForAllPatients();
        $output->writeln('<info>Mailing started</info>');

        array_map(
            function ($patient) use ($output) {
                $tomorrowAppointments = array_values(
                    array_filter(
                        $patient->getAppointments()->getValues(),
                        function (Appointments $appointment) {
                            $dateTime = $appointment->getTime()->format('Y-m-d');
                            $tomorrow = (new \DateTimeImmutable('now'))->modify("+1 day")->format('Y-m-d');

                            return $dateTime == $tomorrow;
                        }
                    )
                );

                try {
                    $this->mailSender->sendAppointmentNotification($patient, $tomorrowAppointments);
                } catch (\Throwable $e) {
                    $this->appointmentEmailCronLogger->error(__METHOD__, ['message' => $e->getMessage()]);

                    $output->writeln(
                        sprintf('<error>Email on address %s was not sent, patient id = %s</error>',
                            $patient->getUser()->getEmail(),
                            $patient->getUser()->getId()
                        )
                    );
                }
            }, $patients
        );

        $output->writeln('<info>Mailing ended successfully</info>');

        return self::SUCCESS;
    }
}
