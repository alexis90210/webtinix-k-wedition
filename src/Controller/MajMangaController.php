<?php

namespace App\Controller;

use App\Entity\KanbanChapitre;
use App\Entity\KanbanManga;
use App\Repository\KanbanMangaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MajMangaController extends AbstractController
{
    #[Route('/admin/maj-manga', name: 'maj_manga')]
    public function index(KanbanMangaRepository $mangas): Response
    {
        return $this->render('maj_manga/maj_manga.html.twig', [
            'mangas' => $mangas->findAll(),
        ]);
    }

    #[Route('/maj-manga/{idManga}/chapitres', name: 'maj_manga_id')]
    public function idx($idManga): Response
    {
        $chapitres = $this->getDoctrine()
            ->getRepository(KanbanChapitre::class)
            ->findOneBy(array('idManga' => $idManga));

        return $this->render('maj_manga/chap_scan.html.twig', [
            'chapitres' => $chapitres
        ]);
    }

}
