<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KanbanRetourInfoController extends AbstractController
{
    #[Route('/kanban/retour/info', name: 'kanban_retour_info')]
    public function index(): Response
    {
        return $this->render('kanban_retour_info/index.html.twig.twig', [
            'controller_name' => 'KanbanRetourInfoController',
        ]);
    }
}
