<?php declare(strict_types=1);

namespace App\Spa\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class SpaController extends AbstractFOSRestController
{
    /**
     * @Rest\Route("/{reactRouting}", name="index", requirements={"reactRouting"="^(?!api|_profiler|admin).+"}, defaults={"reactRouting": null})
     */
    public function index(): Response
    {
        return $this->render('spa/index.html.twig');
    }

    /**
     * @Rest\Route("/administrator/{reactRouting}", name="admin", requirements={"reactRouting"="^administrator(.*)"}, defaults={"reactRouting": null})
     */
    public function admin(): Response
    {
        return $this->render('spa/admin.html.twig');
    }
}
