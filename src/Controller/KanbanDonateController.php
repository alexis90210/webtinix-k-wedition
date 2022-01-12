<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KanbanDonateController extends AbstractController
{
    #[Route('/donate', name: 'donate')]
    public function index(): Response
    {
        return $this->render('public_template/donate.html.twig', [   ]);
    }
}
