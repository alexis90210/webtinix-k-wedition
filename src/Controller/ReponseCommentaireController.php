<?php

namespace App\Controller;


use App\Entity\KanbanChapitre;
use App\Entity\KanbanCommentaire;
use App\Entity\KanbanCommentaireReponse;
use App\Form\KanbanReponseCommentaireType;
use Doctrine\DBAL\DriverManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ReponseCommentaireController extends AbstractController
{

    #[Route('commentaire/reponse/{idChapitre}-{idPosteur}-{idComment}', name: 'reponse')]
    public function index($idChapitre, $idComment,$idPosteur, Request $request, Session $session): Response
    {

        $userId = empty($session->get('member_logged_id'))?$session->get('admin_role_id'):$session->get('member_logged_id');

        $NewReponse = new KanbanCommentaireReponse();
        $form = $this->createForm(KanbanReponseCommentaireType::class,$NewReponse);
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

        $reponses = $queryBuilder
            ->select("com.id AS id_com,com.reponse_commentaire , com.id_chapitre, com.post_at,user.avatar, user.id AS user_id, user.pseudo, chapitre.titre_chapitre, chapitre.numero_chapitre, chapitre.status_chapitre")
            ->from('kanban_commentaire_reponse', 'com')
            ->Join('com', 'kanban_user', 'user', 'user.id = com.id_membre')
            ->Join('com', 'kanban_chapitre', 'chapitre', 'chapitre.id = com.id_chapitre')
            ->where("com.id_chapitre = ".$idChapitre."")
            ->andWhere("user.id = ".$idPosteur."")
            ->andWhere("com.id_commentaire = ".$idComment."")
            ->execute()
            ->fetchAllAssociative()
        ;
        //dd($reponses);

        //---------------------------------------------------

        $commentQuery = $this->getDoctrine()
            ->getRepository(KanbanCommentaire::class)
            ->findOneBy(array(
                'id' => $idComment
            ));
        //dd($commentQuery);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $comment = $form['reponseCommentaire']->getData();

            if (!empty($checkIdChapitre) )
            {
                $checkCommentaire2x = $this->getDoctrine()
                    ->getRepository(KanbanCommentaireReponse::class)
                    ->findOneBy(array(
                        'idMembre' => $userId,
                        'idChapitre' => $idChapitre,
                        'reponseCommentaire' => $comment
                    ));

                if (!empty($checkCommentaire2x))
                {
                    $this->addFlash('success','Doublon interdit');
                }
                else{

                    $NewReponse->setPostAt(date("d/m/Y - H:i:s"));
                    $NewReponse->setIdMembre(intval($userId));
                    $NewReponse->setIdCommentaire(intval($idComment));
                    $NewReponse->setIdChapitre(intval($idChapitre));
                    $em->persist($NewReponse);
                    $em->flush();
                    $this->addFlash('success','reponse poste avec success');

                }
            }
        }

        return $this->render('public_template/reponse.html.twig', [
            'form' => $form->createView(),
            'reponses' => $reponses,
            'totalReponse' => count($reponses),
            'chapitreInfo' => $chapitreInfo,
            'description' => $commentQuery->getCommentaire()
        ]);
    }

}