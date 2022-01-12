<?php

namespace App\Controller;

use App\Entity\Authentificator;
use App\Entity\KanbanUser;
use App\Form\InscriptionType;
use App\Form\PutNewPasswordType;
use App\Form\RecuperationType;
use App\Form\ReinitialisationCompteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class DeconnexionController extends AbstractController
{
    #[Route('/deconnexion/', name: 'deconnexion')]
    public function index(Session $session): Response
    {
        if ($session->get('admin_role') == true)
        {
            $session->remove('admin_role');
        } else{
            $session->remove('member_logged');
            $session->remove('member_logged_id');
            $session->remove('member_logged_email');
            $session->remove('member_logged_avatar');
        }
        return $this->redirectToRoute('home');
    }

    #[Route('/recuperation', name:'recuperation')]
    function r(Request $request, MailerInterface $mailer, Session $session) : Response
    {
        $memberKanban = new KanbanUser();
        $form = $this->createForm(RecuperationType::class,$memberKanban);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $email= $form['email']->getData();

            $MemberBannit = $this->getDoctrine()
                ->getRepository(KanbanUser::class)
                ->findOneBy(array('email' => $email, 'MembreBanni'=>'1'));

            if (!empty($MemberBannit)) {
                $this->addFlash('success','Desole vous avez ete bannit par l\'admin');

                // redirect to last visited url
                $referer = $request->headers->get('referer');
                return $this->redirect($referer);
            }

            $MemberExists = $this->getDoctrine()
                ->getRepository(KanbanUser::class)
                ->findOneBy(array('email' => $email));
            if (empty($MemberExists)) {
                $this->addFlash('success','ce mail n\'est pas enregistre, Ou votre nompte n\'est pas active');
            }
            else{
                $temp = $email;
                $url = 'http://localhost:8000/recuperation/'.$temp.'/'.$MemberExists->getToken();

                // send mail confirmation
                $MyEmail = (new Email())
                    ->from('alexisng90210@gmail.com')
                    ->to($email)
                    //->cc('cc@example.com')
                    //->bcc('bcc@example.com')
                    //->replyTo('fabien@example.com')
                    //->priority(Email::PRIORITY_HIGH)
                    ->subject('Kanban Blog | Compte recuperation code !')
                    ->text('Hello! '.$email.'')
                    ->html('<p>cliquez <a href="'.$url.'">ici</a> pour recuperer votre compte</p>');
                $mailer->send($MyEmail);
                $session->set('emailRecup',$email);
                $this->addFlash('success','Verifiez votre boite mail pour activer votre compte');


            }
        }
        return $this->Render('public_template/recuperation.html.twig',
            ['form' => $form->createView()]
        );
    }

    #[Route('/recuperation/{temp}/{token}', name:'recuperation_newpass_compte')]
    function k($temp, $token, Request $request, Session $session) : Response
    {
        $memberKanban = new KanbanUser();
        $form = $this->createForm(ReinitialisationCompteType::class,$memberKanban);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $PlainPassword= $form['PlainPassword']->getData();
            $emailFromSession = $session->get('emailRecup');

            if ($emailFromSession != $temp)
            {
                $MemberExists = $this->getDoctrine()
                    ->getRepository(KanbanUser::class)
                    ->findOneBy(array('token' => $token));
                if (empty($MemberExists))
                {
                    $this->addFlash('success','desole ! un probleme survenu');
                }
                $this->addFlash('success','desole ! erreur dans la session , veuillez recommencer la procedure');
            }
            else{
                $MemberExists = $this->getDoctrine()
                    ->getRepository(KanbanUser::class)
                    ->findOneBy(array('token' => $token));
                if (!empty($MemberExists))
                {
                    $req = $this->getDoctrine()->getManager();
                    $MemberExists->setPassword(password_hash($PlainPassword,PASSWORD_DEFAULT));
                    $req->flush();
                    $this->addFlash('success','Mot de passe reinitialise avec success ');
                    $this->addFlash('success','veuillez vous connecter avec votre nouveau password ');
                }
                else{
                    $this->addFlash('success','url incorrect');

                }
            }
        }
        return $this->Render('public_template/new_password.html.twig',
            ['form' => $form->createView()]
        );
    }

}
