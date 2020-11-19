<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainWorkerController extends AbstractController
{
    /**
     * @Route("/", name="worker_home")
     */
    public function index()
    {
        return $this->render('main_worker/index.html.twig', [
            'controller_name' => 'MainWorkerController',
        ]);
    }
}
