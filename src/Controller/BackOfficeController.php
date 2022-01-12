<?php

namespace App\Controller;

use App\Entity\KanbanChapitre;
use App\Entity\KanbanInfoCulturelle;
use App\Entity\KanbanManga;
use App\Entity\KanbanScan;
use App\Entity\KanbanUser;
use App\Form\InscriptionType;
use App\Form\KanbanInfoCulturelleType;
use App\Form\KanbanMangaChapitreType;
use App\Form\KanbanMangaChaptireScanType;
use App\Form\KanbanMangaType;
use App\Repository\KanbanInfoCulturelleRepository;
use App\Repository\KanbanMangaRepository;
use App\Repository\WebtinixKanbanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class BackOfficeController extends AbstractController
{
        #[Route('/admin/home', name:'admin')]
        function index(KanbanInfoCulturelleRepository $info_cult,
                       KanbanMangaRepository $manga ,
                       WebtinixKanbanRepository $members,
                       Session $session,
                       Request $request
        ) : Response{
            if ($session->get('admin-logged') != 'true')
            {
                return $this->redirect('/');
            }
            return $this->render('backoffice/backoffice.html.twig',
                [
                    'info_culturelle' => $info_cult->findAll(),
                    'mangas' => $manga->findAll(),
                    'members' => $members->findAll()
                ]
            );
        }

    #[Route('/admin/post/Manga', name:'admin_post_manga')]
    function manga(Request $request, Session $session) : Response
    {
        if ($session->get('admin-logged') != 'true')
        {
            // redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }
        $NewManga = new KanbanManga();
        $form = $this->createForm(KanbanMangaType::class,$NewManga);
        $form->handleRequest($request);
        //dd($session);
        if ($form->isSubmitted() && $form->isValid())
        {
            $req = $this->getDoctrine()->getManager();
            $titre = $form['titre']->getData();

            $MangaExists = $this->getDoctrine()
                ->getRepository(KanbanManga::class)
                ->findOneBy(array('titre' => $titre));

            if (empty($MangaExists))
            {
                // insert in manga table
                $MangaTable = $this->getDoctrine()->getManager();
                $MangaTable->persist($NewManga);
                $MangaTable->flush();
                $this->addFlash('success','success : Le manga '.$titre.' | posted ');

                $session->set('manga_titre',$titre);
                $session->set('mangaId',$NewManga->getIdManga());
                return $this->redirect('/admin/post/Manga/'.$titre.'/chapitre');

            } else {
                $this->addFlash('success','Le manga contenant le titre :  '.$titre.' est deja publique
             ');
            }
        }

        return $this->render('poster/manga/manga.html.twig',
            ['form'=> $form->createView() ]
        );
    }


    #[Route('/admin/post/Manga/{titre}/chapitre', name:'post_manga_chap')]
    function tw($titre, Session $session, Request $request):Response
    {
        if ($session->get('admin-logged') != 'true')
        {
            // redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }
        $sessionTitre = $session->get('manga_titre');
        //dd($sessionTitre);
        if ($titre != $sessionTitre)
        {
            //redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }
        $NewMangaChapitre = new KanbanChapitre();
        $form = $this->createForm(KanbanMangaChapitreType::class,$NewMangaChapitre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $chapitre = $form['nomChapitre']->getData();

            // insert in manga table
            $em= $this->getDoctrine()->getManager();
            $NewMangaChapitre->setIdManga(intval($session->get('mangaId')));
            $em->persist($NewMangaChapitre);
            $em->flush();
            $session->set('manga_chapitre',$chapitre);

            return $this->redirect('/admin/post/manga/'.$titre.'/chapitre/'.$chapitre.'');
        }
        return $this->render('chapitre/chapitre.html.twig',
            [
            'form' => $form->createView(),
            'session' => $sessionTitre
        ]);
    }
    #[Route('/admin/post/manga/{titre}/chapitre/{chapitre}', name:'admin_post_manga_chap')]
    function ct($titre , $chapitre , Request $request , Session $session):Response
    {
        if ($session->get('admin-logged') != 'true')
        {
            // redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }

        $NewMangaChapitreScan = new KanbanScan();
        $form = $this->createForm(KanbanMangaChaptireScanType::class,$NewMangaChapitreScan);
        $form->handleRequest($request);

        if ($session->get('manga_chapitre') != $chapitre)
        {
            // redirect to last visited url
            $this->addFlash('success','probleme dans l URL');
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }
        return $this->render('scan/scan.html.twig.twig',
            [
                'form' => $form->createView(),
                'session' => $titre ,
                'manga_chapitre' => $session->get('manga_chapitre')
            ]);
    }

    #[Route('/admin/post/Info-culturelle', name:'admin_post_if')]
    function culture(Request $request, Session $session) : Response{

        if ($session->get('admin-logged') != 'true')
        {
            // redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }
        // check if is admin

        $NewIF = new KanbanInfoCulturelle();
        $form = $this->createForm(KanbanInfoCulturelleType::class,$NewIF);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $req = $this->getDoctrine()->getManager();
            $titre = $form['titre']->getData();

            $INFOExists = $this->getDoctrine()
                ->getRepository(KanbanManga::class)
                ->findOneBy(array('titre' => $titre));

            if (empty($INFOExists))
            {
                // insert in manga table
                $MangaTable = $this->getDoctrine()->getManager();
                $MangaTable->persist($NewIF);
                $MangaTable->flush();
                $this->addFlash('success','success : IF '.$titre.' | posted ');
            } else {
                $this->addFlash('success','Le IF contenant le titre :  '.$titre.' est deja publique
             ');
            }
        }
        // check if is admin

        return $this->render('poster/culture/culture.html.twig',
            ['form'=> $form->createView() ]
        );
    }

    #[Route('/admin/supprime/IF/{id}' , name:'supp_if')]
    function supp($id, Request $request, Session $session) : Response
    {
        if ($session->get('admin-logged') != 'true')
        {
            // redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }

        if (!is_int($id)){
            $id = intval($id);
        }
        $em = $this->getDoctrine()->getManager();
        $getIF = $this->getDoctrine()
            ->getRepository(KanbanInfoCulturelle::class)
            ->findOneBy(array('id' => $id));
        if (empty($getIF))
        {
            $this->addFlash('success','erreur id');
        } else {
            $em->remove($getIF);
            $em->flush();
            $this->addFlash('success','supprime avec success');
        }
        // redirect to last visited url
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    #[Route('/admin/supprime/manga/{id}' , name:'supp_manga')]
    function supprime($id, Request $request, Session $session) : Response
    {
        if ($session->get('admin-logged') != 'true')
        {
            // redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }

        if (!is_int($id)){
            $id = intval($id);
        }
        $em = $this->getDoctrine()->getManager();
        $getManga = $this->getDoctrine()
            ->getRepository(KanbanManga::class)
            ->findOneBy(array('id' => $id));
        if (empty($getManga))
        {
            $this->addFlash('success','erreur id');
        } else {
            $em->remove($getManga);
            $em->flush();
            $this->addFlash('success','supprime avec success');
        }
        // redirect to last visited url
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }


    #[Route('/admin/supprime/membre/{id}' , name:'supp_membre')]
    function i($id, Request $request, Session $session) : Response
    {
        if ($session->get('admin-logged') != 'true')
        {
            // redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }

        if (!is_int($id)){
            $id = intval($id);
        }
        $em = $this->getDoctrine()->getManager();
        $getMembre = $this->getDoctrine()
            ->getRepository(KanbanUser::class)
            ->findOneBy(array('id' => $id));
        if (empty($getMembre))
        {
            $this->addFlash('success','erreur id');
        } else {
            $em->remove($getMembre);
            $em->flush();
            $this->addFlash('success','bannit avec success');
        }
        // redirect to last visited url
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }


}