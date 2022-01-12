<?php

namespace App\Controller;

use App\Repository\KanbanMangaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KanbanDecouverteController extends AbstractController
{
    #[Route('/decouverte', name: 'decouverte')]
    public function index(KanbanMangaRepository $decouverte): Response
    {
        //dd($decouverte->findBy(array('decouverte'=>true)));
        return $this->render('public_template/decouverte.html.twig', [
            'mangas' => $decouverte->findBy(array('decouverte'=>true)),
            'result'=>''
        ]);
    }
}
