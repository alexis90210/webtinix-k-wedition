<?php

namespace App\Controller;

use App\Entity\KanbanChapitre;
use App\Entity\KanbanManga;
use App\Entity\KanbanMangaGenre;
use App\Entity\KanbanScan;
use App\Form\SearchBarType;
use App\Repository\KanbanChapitreRepository;
use App\Repository\KanbanMangaRepository;
use App\Repository\KanbanScanRepository;
use Doctrine\DBAL\DriverManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class MangasController extends AbstractController
{
    #[Route('/mangas', name: 'mangas')]
    public function index(Request $request, Session $session ): Response
    {
        $attrs = $session->get('attrs');
            
        $conn = DriverManager::getConnection($attrs);
        $queryBuilder = $conn->createQueryBuilder();

        $mangas = $queryBuilder
            ->select('DISTINCT u.id_manga, u.manga_cover',' u.titre_manga','p.dernier_chapitre')
            ->from('kanban_manga', 'u')
            ->Join('u', 'kanban_manga_nouveaute', 'p', 'u.id_manga = p.id_manga')
            ->execute()
            ->fetchAllAssociative()
        ;

        // new connection
        $con = DriverManager::getConnection($attrs);
        $queryBuilder = $con->createQueryBuilder();

        $mangaSearchResults ='';

        $form = $this->createForm(SearchBarType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $key = $form['search']->getData();
            $extract_keys = explode(' ',$key);

            $condition = "";
            foreach ($extract_keys as $x => $v)
            {
                $v = htmlspecialchars(htmlentities(trim($v)));
                $condition .= (strlen($condition) > 0 ? ' OR ' : '') . ' (u.titre_manga LIKE "%' . $v . '%" OR c.titre_chapitre LIKE "%' . $v . '%"' . (is_int($v) ? ' OR p.dernier_chapitre = ' . $v : '') . ') ';
            }
            $mangaSearchResults = $queryBuilder
                ->select('u.manga_cover,u.id_manga','u.titre_manga','p.dernier_chapitre, c.titre_chapitre')
                ->from('kanban_manga', 'u')
                ->Join('u', 'kanban_manga_nouveaute', 'p', 'u.id_manga = p.id_manga')
                ->Join('u', 'kanban_chapitre', 'c', 'u.id_manga = c.id_manga')
                ->where($condition)
                //->getSQL()
                ->execute()
                ->fetchAllAssociative()
            ;
            //dd($mangaSearchResults);
        }

        return $this->render('public_template/bd.html.twig', [
            'mangas' => $mangas,
            'result' => $mangaSearchResults,
            'form' => $form->createView()
        ]);
    }

    #[Route('/mangas/{idManga}-chapitres', name: 'chapitre')]
    public function in( $idManga, Session $session): Response
    {
        $attrs = $session->get('attrs');
            
        $conn = DriverManager::getConnection($attrs);
        $queryBuilder = $conn->createQueryBuilder();

        $chapitres = $queryBuilder
            ->select('u.titre_manga',
                'p.titre_chapitre, p.image,p.date_sortie_chapitre','p.status_chapitre',
                'p.numero_chapitre','u.id_manga',
                'p.status_chapitre','p.id',
                "( SELECT COUNT(commentaire) FROM kanban_commentaire WHERE kanban_commentaire.id_chapitre = p.id ) AS 'NbreCommentaire',  ( SELECT COUNT(like_chapitre) FROM kanban_like WHERE kanban_like.id_chapitre = p.id ) AS 'NbreLike'"
            )
            ->from('kanban_manga', 'u')
            ->Join('u', 'kanban_chapitre', 'p', 'p.id_manga = u.id_manga ')
            ->where('u.id_manga = :idManga AND p.status_chapitre = :status')
            ->setParameters(array(
                'idManga'=>$idManga,
                'status' => 'Termine'
            ))
            ->execute()
            ->fetchAllAssociative()
        ;

        $manga = $this->getDoctrine()
            ->getRepository(KanbanManga::class)
            ->findOneBy(array('idManga' => $idManga));

        $genre = $this->getDoctrine()
            ->getRepository(KanbanMangaGenre::class)
            ->findOneBy(array('idManga' => $idManga));
        $genres = explode('/',$genre->getGenreManga());

        //dd($manga);
        return $this->render('public_template/single-bd.html.twig', [
            'chapitres' => $chapitres,
            'mangaTitre' => $manga->getTitreManga(),
            'mangaStatus' => $manga->getStatusManga(),
            'mangaAuteur' => $manga->getAuteurManga(),
            'NbreChapitres' => count($chapitres),
            'genres' =>$genres,
            'cover'=>$manga->getMangaCover(),
            'profile'=> $manga->getMangaProfile()
        ]);
    }
/*
    #[Route('/mangas/{manga}/{idChapitre}/scans', name: 'scans-list')]
    public function i($manga, $idChapitre): Response
    {

        $scans = $this->getDoctrine()
            ->getRepository(KanbanScan::class)
            ->findBy(array('idChapitre' => $idChapitre));

        $chapitre = $this->getDoctrine()
            ->getRepository(KanbanChapitre::class)
            ->findOneBy(array('id' => $idChapitre));

        return $this->render('scans-list/scan-list_user.html.twig', [
            'scans_list' => $scans,
            'manga' => $manga,
            'chapitre' => $chapitre->getNomChapitre()
        ]);
    }*/

/*
    #[Route('/mangas/{manga}/{idChapitre}/scans/{idScan}', name: 'scan-detail')]
    public function iz($manga, $idChapitre, $idScan,
                      Session $session, Request $request, KanbanScanRepository $scans
    ): Response
    {
        $all_scan = $scans->findOneBy(array(
            'idChapitre' => $idChapitre
        ));
        $nombreScan = count($all_scan->getListScan());

        if ($idScan > intval($nombreScan * .75))
        {
            return new Response('vous devez etre membre pour lire ce scan');
        }

        if ($session->get('member-logged') != 'true')
        {
            // redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }

        $scans = $this->getDoctrine()
            ->getRepository(KanbanScan::class)
            ->findBy(array('idChapitre' => $idChapitre));

        $chapitre = $this->getDoctrine()
            ->getRepository(KanbanChapitre::class)
            ->findOneBy(array('id' => $idChapitre));

        return $this->render('scans-list/scan-list_user.html.twig', [
            'scans_list' => $scans,
            'manga' => $manga,
            'chapitre' => $chapitre->getNomChapitre()
        ]);
    }*/


}
