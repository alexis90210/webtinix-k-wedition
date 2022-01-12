<?php

namespace App\Controller;

use App\Entity\Authentificator;
use App\Entity\KanbanUser;
use App\Form\InscriptionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mime\Email;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;


class InscriptionControler extends AbstractController
{

    public function __construct()
    {
    }

    /**
     * @Route("/inscription", name="inscription")
     * @return Response
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    function inscription(Request $request, MailerInterface $mailer): Response
    {
        $memberKanban = new KanbanUser();
        $form = $this->createForm(InscriptionType::class,$memberKanban);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $req = $this->getDoctrine()->getManager();
            $pseudo= $form['pseudo']->getData();
            $email= $form['email']->getData();
            $password= $form['password']->getData();
            $conf_pass = $form['ConfirmezPassword']->getData();

            if ($conf_pass != $password)
            {
                 $this->addFlash('success', 'Les deux mots de passe ne correspondent pas');
            }
            else{
                $memberKanban->setPassword(password_hash($password,PASSWORD_DEFAULT));

                $checkPseudo = $this->getDoctrine()->
                getRepository(KanbanUser::class)
                    ->findOneBy(array(
                        'pseudo' => $pseudo
                    ));
                if (!empty($checkPseudo)){
                    $this->addFlash('success','pseudo deja pris');
                    // redirect to last visited url
                    $referer = $request->headers->get('referer');
                    return $this->redirect($referer);

                }

                $MemberExists = $this->getDoctrine()
                    ->getRepository(KanbanUser::class)
                    ->findOneBy(array(
                        'email' => $email
                    ));
                if (empty($MemberExists))
                {
                    $MemberBannit = $this->getDoctrine()
                        ->getRepository(KanbanUser::class)
                        ->findOneBy(array('email' => $email, 'MembreBanni'=>'1'));
                    if (!empty($MemberBannit)) {
                        $this->addFlash('success','Desole vous avez ete bannit par l\'admin');

                        // redirect to last visited url
                        $referer = $request->headers->get('referer');
                        return $this->redirect($referer);
                    }

                    // generate url for confirmation
                    $url = 'http://localhost:8000/confirmation/'.$memberKanban->getToken();
                    $memberKanban->setAvatar('https://pic.onlinewebfonts.com/svg/img_173956.png');
                    $memberKanban->setAdmin('USER');
                    $memberKanban->setMembreBanni('0');
                    $req->persist($memberKanban);
                    $req->flush();


                    $this->addFlash('success','vous etes bien inscris avec :  '.$memberKanban->getEmail() .'
             ');

                    // send mail confirmation
                    $MyEmail = (new Email())
                        ->from('alexisng90210@gmail.com')
                        ->to($email)
                        //->cc('cc@example.com')
                        //->bcc('bcc@example.com')
                        //->replyTo('fabien@example.com')
                        //->priority(Email::PRIORITY_HIGH)
                        ->subject('Kanban Blog | Email confirmation!')
                        ->text('Hello! '.$email.'')
                        ->html('<p>cliquez <a href="'.$url.'">ici</a> pour activer votre compte</p>');
                    $mailer->send($MyEmail);
                    $this->addFlash('success','Verifiez votre boite mail pour activer votre compte');

                }
                else{
                    $this->addFlash('success','Email deja pris');
                }
            }


        }

        return $this->Render('public_template/register.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/confirmation/{token}", name="confirm_compte")
     * @return Response
     */
    function confirmationCompte(Request $request, $token, Session $session): Response
    {
        // search for unique token

        $dbToken = $this->getDoctrine()->getRepository(KanbanUser::class)
            ->findOneBy(array(
                'token' => strval($token)
                ));

        if ($token == $dbToken->getToken())
        {
            $memberKanban = new KanbanUser();
            $req = $this->getDoctrine()->getManager();
            $user = $req->getRepository(KanbanUser::class,$memberKanban)
                ->findOneBy(array('token'=>$token));
            $user->setVerifieEmail('1');
            $req->flush();
            $session->set('confirmationSucccess','votre compte a ete confirme avec success, veuillez vous connecter');
            return $this->redirectToRoute('connexion');
        } else{
            return new Response('Votre token n\'est pas valide');
        }
    }




}