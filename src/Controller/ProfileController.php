<?php

namespace App\Controller;

use App\Entity\KanbanCommentaire;
use App\Entity\KanbanLike;
use App\Entity\KanbanManga;
use App\Entity\KanbanUser;
use App\Form\EditProfileType;
use App\Form\InscriptionType;
use App\Form\ReinitialisationCompteType;
use App\Form\SearchBarType;
use App\Repository\KanbanInfoCulturelleRepository;
use App\Repository\KanbanMangaRepository;
use App\service\fileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function index(Session $session, Request $request, fileUploader $file_uploader): Response
    {
        if ( empty($session->get('member_logged'))  && empty($session->get('admin_role') ))
        { return $this->redirectToRoute('home'); }


        $checkCompte = $this->getDoctrine()
            ->getRepository(KanbanUser::class)
            ->findOneBy(array(
                'email' => empty($session->get('member_logged_email'))?$session->get('admin_role_email'):$session->get('member_logged_email'),
            ));
        if (empty($checkCompte)) {
            return new Response('violation du compte');
        }

        $memberKanban = new KanbanUser();
        $form = $this->createForm(EditProfileType::class,$memberKanban);
        $form->handleRequest($request);
        //dd($session->get('member_logged_avatar'));
        if ($form->isSubmitted() && $form->isValid()) {

            $pseudo = $form['pseudo']->getData();
           /* $password = $form['password']->getData();
            $conf_pass = $form['ConfirmezPassword']->getData();*/
            $avatar = $form['avatar']->getData();

            /*if ($conf_pass != $password) {
                $this->addFlash('error', 'Les deux mots de passe ne correspondent pas');

                // redirect to last visited url
                $referer = $request->headers->get('referer');
                return $this->redirect($referer);
            }*/

          /*  if ($session->get('member_logged_pseudo') == $pseudo) {
                $this->addFlash('success', 'ceci n\'est autre que votre ancien pseudo');

                // redirect to last visited url
                $referer = $request->headers->get('referer');
                return $this->redirect($referer);
            }*/

           /* if ($session->get('member_logged_password') != $password) {
                $this->addFlash('success', 'mot de passe incorrect');

                // redirect to last visited url
                $referer = $request->headers->get('referer');
                return $this->redirect($referer);
            }*/

            /*$checkPseudo = $this->getDoctrine()->
            getRepository(KanbanUser::class)
                ->findOneBy(array(
                    'id'=> $session->get('member_logged_id') ,
                    'pseudo' => $pseudo
                ));
            if (empty($checkPseudo)){

                $this->addFlash('success','pseudo incorrect');

                $session->set('member_logged_pseudo',$pseudo);

                // redirect to last visited url
                $referer = $request->headers->get('referer');
                return $this->redirect($referer);

            }*/


            if (!empty($avatar))
            {
                 $file_name_avatar = $file_uploader->upload($avatar);
                // file as been uploaded , now check public/uploads to see it

                if (null != $file_name_avatar)
                {
                    $directory = $file_uploader->getTargetDirectory();
                    $full_path = $directory.'/'. $file_name_avatar;

                    $em = $this->getDoctrine()->getManager();
                    $member = new KanbanUser();
                    $mod = $em->getRepository(KanbanUser::class,$member)
                        ->findOneBy(array(
                            'id' => empty($session->get('member_logged_id'))?$session->get("admin_role_id"):$session->get("member_logged_id")
                        ));
                    $mod->setPseudo(htmlspecialchars($pseudo));
                    $mod->setAvatar($file_name_avatar);
                    $em->flush();

                    $session->set('member_logged_pseudo',$pseudo);

                    $this->addFlash('success','Photo de profile et Pseudo sont mis a jour');

                }
            }
            else{
                $em = $this->getDoctrine()->getManager();
                $member = new KanbanUser();
                $mod = $em->getRepository(KanbanUser::class,$member)
                    ->findOneBy(array(
                        'id' => empty($session->get('member_logged_id'))?$session->get("admin_role_id"):$session->get("member_logged_id")
                    ));
                $mod->setPseudo(htmlspecialchars($pseudo));
                $em->flush();

                //$session->set('member_logged_pseudo',$pseudo);

                $this->addFlash('success','Pseudo mis a jour, les modification prendront effet a la prochaine connexion');

            }
            // redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);

        }

        return $this->render('public_template/account.html.twig',[
            'form' => $form->createView() ,
            'pseudo' => empty($session->get("member_logged_pseudo"))?$session->get("admin_role_name"):$session->get("member_logged_pseudo")
        ]);
    }

    #[Route('/like/{mangaId}/{idChapitre}', name: 'like')]
    function l($mangaId,$idChapitre, Request $request, Session $session) : Response
    {
        if (($session->get('member_logged') == true) || $session->get('admin_role') == true)
        {
            $memberId = empty($session->get('member_logged_id'))?$session->get('admin_role_id'):$session->get('member_logged_id');

            if (empty( $this->getDoctrine()
               ->getRepository(KanbanLike::class)
               ->findOneBy(array(
                   'memberId' => $memberId,
                   'IdChapitre' => $idChapitre
               )))){

               $em = $this->getDoctrine()->getManager();

               $like = new KanbanLike();
               $like->setMemberId($memberId);
                $like->setMangaId(0);
               $like->setIdChapitre($idChapitre);
               $like->setLikeChapitre('');
               $like->setStatus('1');
               $like->setLikeChapitre('1');

               $em->persist($like);
               $em->flush();

               // redirect to last visited url
               $referer = $request->headers->get('referer');
               return $this->redirect($referer);
           }
           else{

               $em = $this->getDoctrine()->getManager();
               $like = new KanbanLike();
               $liker = $em->getRepository(KanbanLike::class,$like)
                   ->findOneBy(array(
                       'memberId' => $memberId,
                       'IdChapitre' => $idChapitre
                   ));
               $em->remove($liker);
               $em->flush();

               // redirect to last visited url
               $referer = $request->headers->get('referer');
               return $this->redirect($referer);
           }
        } else {

            $this->addFlash('pas_auth','Vous devez etre connecte pour liker un manga ou un chapitre');
            // redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }

    }
/*
    #[Route('/edit/{token}/{email}', name: 'edit_compte')]
    function e($token , $email, Request $request, Session $session) : Response {

        if ($session->get('member-logged') != 'true')
        {
            // redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }

        $member = new KanbanUser();
        $form = $this->createForm(ReinitialisationCompteType::class,$member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $password = $form['password']->getData();

            $MemberExists = $this->getDoctrine()
                ->getRepository(KanbanUser::class)
                ->findOneBy(array(
                    'email' => $email,
                    'token' => $token
                ));
            if (empty($MemberExists))
            {  $this->addFlash('success','Erreur url'); }
            else{
                $em = $this->getDoctrine()->getManager();
                $member = new KanbanUser();
                $comm = $em->getRepository(KanbanUser::class,$member)
                    ->findOneBy(array(
                        'email' => $email,
                        'token' => $token
                    ));
                $comm->setPassword(password_hash($password,PASSWORD_DEFAULT));
                $em->flush();

                $this->addFlash('success','votre mot de passe vient de changer');
            }

        }

            return $this->render('reinitialisation/reinitialisation.html.twig',
            ['form' => $form->createView()]
        );
    }*/

}
