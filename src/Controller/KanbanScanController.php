<?php

namespace App\Controller;

use App\Entity\KanbanChapitre;
use App\Entity\KanbanScan;
use App\Repository\KanbanLikeSystemRepository;
use App\Repository\KanbanScanRepository;
use Proxies\__CG__\App\Entity\KanbanLike;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class KanbanScanController extends AbstractController
{
    #[Route('/mangas/{idManga}-{mangaTitre}-{idChapitre}-scans-{idScan}', name: 'scans')]
    public function index($idManga,$mangaTitre, $idChapitre, $idScan,
                          Session $session, Request $request, KanbanScanRepository $scans
    ): Response
    {

        if ($idScan == 0 ){
            return $this->redirect('/mangas/'.$idManga.'-'.$mangaTitre.'-'.$idChapitre.'-scans-1');
        }
        $scans = $scans->findBy(array(
            'idChapitre' => $idChapitre ,
            'idManga' =>$idManga
        ));

        $nombreScan = array();

        foreach ($scans as $key)
        {
            $nombreScan[] = $key->getScanImages();
        }


        if ( empty($session->get('member_logged')) && empty($session->get('admin_role')) )
        {
            if ($idScan > intval(count($nombreScan) * .75))
            {
                return new Response('vous devez etre membre pour lire ce scan');
            }
        }
        $likes = $this->getDoctrine()->getRepository(KanbanLike::class)
            ->findBy(array('IdChapitre'=>$idChapitre)
        );


        return $this->render('public_template/scan.html.twig', [
            'scan'=> $nombreScan[$idScan-1],
            'progress'=>intval((($idScan)/(count($nombreScan)))*100),
            'scanLeft' => $idScan-1,
            'scanRight' => $idScan+1,
            'idManga' => $idManga,
            'idChapitre' => $idChapitre,
            'mangaTitre' => $mangaTitre,
            'idScan' => $idScan,
            'totalScan' => count($nombreScan),
            'totalLike' => count($likes)
        ]);
    }
}
