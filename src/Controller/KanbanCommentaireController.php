<?php

namespace App\Controller;

use App\Entity\KanbanChapitre;
use App\Entity\KanbanCommentaire;
use App\Entity\KanbanCommentaireReponse;
use App\Form\KanbanCommentaireType;
use App\Form\KanbanReponseCommentaireType;
use Doctrine\DBAL\DriverManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class KanbanCommentaireController extends AbstractController
{
    #[Route('/commentaire/{idChapitre}', name: 'commentaire')]
    public function index($idChapitre, Request $request, Session $session): Response
    {
        $userId = empty($session->get('member_logged_id'))?$session->get('admin_role_id'):$session->get('member_logged_id');

        $NewComment = new KanbanCommentaire();
        $form = $this->createForm(KanbanCommentaireType::class,$NewComment);
        $form->handleRequest($request);

        $checkIdChapitre = $this->getDoctrine()
            ->getRepository(KanbanChapitre::class)
            ->findOneBy(array(
                'id' => $idChapitre
            ));
        if (empty($checkIdChapitre))
        {
            return new Response('ce chapitre n\'est pas repertorie');
        }


        $attrs = $session->get('attrs');
            
        $con = DriverManager::getConnection($attrs);
        $queryBuilder = $con->createQueryBuilder();

        $chapitreInfo = $queryBuilder
            ->select(
            'u.titre_manga','u.id_manga',
            'p.titre_chapitre','p.numero_chapitre',
            'p.status_chapitre','p.id','p.date_sortie_chapitre','p.description'
        )
            ->from('kanban_manga', 'u')
            ->Join('u', 'kanban_chapitre', 'p', 'u.id_manga = p.id_manga')
            ->where("p.id = '".$idChapitre."'")
            ->execute()
            ->fetchAssociative()
        ;

        //---------------------------------------------------

        $conn = DriverManager::getConnection($attrs);
        $queryBuilder = $conn->createQueryBuilder();

        $commentaires = $queryBuilder
            ->select( "com.id AS id_com,com.commentaire , com.id_chapitre, com.poste_at,user.avatar, user.id AS user_id, user.pseudo,chapitre.titre_chapitre, chapitre.numero_chapitre, chapitre.status_chapitre,chapitre.id as chap_id,(SELECT COUNT(reponse_commentaire) FROM kanban_commentaire_reponse WHERE id_commentaire = com.id AND id_membre = user.id AND id_chapitre = '".$idChapitre."') AS 'nbreReponse'")
            ->from('kanban_commentaire', 'com')
            ->Join('com', 'kanban_user', 'user', 'user.id = com.membre_id')
            ->Join('com', 'kanban_chapitre', 'chapitre', 'chapitre.id = com.id_chapitre')
            ->where("com.id_chapitre = ".$idChapitre."")
            ->andWhere("com.supprime_commentaire = '0'")
            ->execute()
            ->fetchAllAssociative()
        ;

        //---------------------------------------------------

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $comment = $form['commentaire']->getData();

            if (!empty($checkIdChapitre) )
            {
                $checkCommentaire2x = $this->getDoctrine()
                    ->getRepository(KanbanCommentaire::class)
                    ->findOneBy(array(
                        'membreId' => $userId,
                        'IdChapitre' => $idChapitre,
                        'commentaire' => $comment,
                        'SupprimeCommentaire' => '0'
                    ));

                if (!empty($checkCommentaire2x))
                {
                    $this->addFlash('success','Doublon interdit');
                }
                else{
                    $NewComment->setMangaId(0);
                    $NewComment->setMembreId(intval($userId));
                    $NewComment->setIdChapitre(intval($idChapitre));
                    $NewComment->setSupprimeCommentaire('0');
                    $em->persist($NewComment);
                    $em->flush();
                    $this->addFlash('success','commentaire poste avec success');

                    $this->redirect('/commentaire/'.$idChapitre);
                }
            }
        }

        return $this->render('public_template/comment.html.twig', [
            'form' => $form->createView(),
            'commentaires' => $commentaires,
            'totalCom' => count($commentaires),
            'chapitreInfo' => $chapitreInfo
        ]);
    }

    #[Route('commentaire/supprime/{idCom}', name: 'sup_commentaire')]
    function s($idCom , Request $request, Session $session): Response
    {
        if ( empty($session->get('admin_role')) && empty($session->get('member_logged')))
        { return $this->redirect('/'); }

        $checkIdCom = $this->getDoctrine()
            ->getRepository(KanbanCommentaire::class)
            ->findOneBy(array(
               empty($session->get('admin_role_id'))? "'id' => $idCom,'membreId' => empty($session->get('member_logged_id'))?$session->get('admin_role_id'):$session->get('member_logged_id')":'id' => $idCom
            ));

        if (empty($checkIdCom))
        {
            $this->addFlash('success','erreur! impossible de supprimer');
            // redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }

        $em = $this->getDoctrine()->getManager();
        $ThisComment = new KanbanCommentaire();
        $comm = $em->getRepository(KanbanCommentaire::class,$ThisComment)
            ->findOneBy(array(
                empty($session->get('admin_role_id'))? "'id' => $idCom,'membreId' => empty($session->get('member_logged_id'))?$session->get('admin_role_id'):$session->get('member_logged_id')":'id' => $idCom
            ));
       // dd($comm);
        $comm->setSupprimeCommentaire('1');
        $em->flush();

        $this->addFlash('success','commentaire supprime avec success');
        // redirect to last visited url
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);

    }
}
