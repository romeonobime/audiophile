<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DetailController extends AbstractController
{
    #[Route('/detail/{slug}', name: 'app_detail')]
    public function index(): Response
    {
        return $this->render('pages/detail.html.twig');
    }
}
