<?php declare(strict_types=1);

namespace App\Catalog\Command;

use App\Catalog\Entity\Service;
use App\Catalog\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CodeGeneratorCommand extends Command
{
    protected static $defaultName = 'services:regenerate_code';

    public function __construct(
        private ServiceRepository $serviceRepository,
        private EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $services = $this->serviceRepository->findAll();
        $code = 100;

        array_map(
            function (Service $service) use (&$code) {
                if (count($service->getServices()->getValues()) === 0) {
                    $service->setCode($code++);
                    $this->entityManager->persist($service);
                }
            }, $services
        );

        try {
            $this->entityManager->flush();
            $this->entityManager->clear();
        } catch (\Throwable $e) {
            $output->writeln('<error>Executing is failed</error>');
            $output->write($e->getMessage());

            return self::FAILURE;
        }

        $output->write('<info>New codes are generated successfully</info>');

        return self::SUCCESS;
    }
}
