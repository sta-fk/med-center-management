<?php declare(strict_types=1);

namespace App\Appointments\Controller\Api;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

class AppointmentsController extends AbstractFOSRestController
{
    /**
     * @Rest\Route("/start-mailing", name="appointment.mailing", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Start sending emails"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Return console outputs",
     * )
     *
     * @OA\Tag(name="appointment")
     *
     * @Rest\View(statusCode=200)
     */
    public function startMailing(KernelInterface $kernel): Response
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $input = new ArrayInput(array(
            'command' => 'appointments:email_notification'
        ));
        $output = new BufferedOutput();

        $application->run($input, $output);

        // return the output
        $content = $output->fetch();

        // Send the output of the console command as response
        return new Response($content);
    }
}
