<?php

namespace App\Controller;

use App\Entity\KanbanSubscriber;
use App\Entity\KanbanUser;
use App\Form\ConnexionType;
use App\Form\KanbanSubscriberType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class KanbanSubscribeController extends AbstractController
{
    #[Route('/subscribe', name: 'subscribe')]
    public function index(Request $request,  MailerInterface $mailer): Response
    {
        $subscriber = new KanbanSubscriber();
        $form = $this->createForm(KanbanSubscriberType::class,$subscriber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form['email']->getData();

            $MemberExists = $this->getDoctrine()
                ->getRepository(KanbanUser::class)
                ->findOneBy(array(
                    'email' => $email
                ));
            if (!empty($MemberExists))
            {
                $this->addFlash('success','En etant membre, vous etes deja souscrit');
                // redirect to last visited url
                $referer = $request->headers->get('referer');
                return $this->redirect($referer);
            }

            $subExists = $this->getDoctrine()
                ->getRepository(KanbanSubscriber::class)
                ->findOneBy(array(
                    'email' => $email
                ));
            if (!empty($subExists))
            {
                $this->addFlash('success','vous etes deja souscrit');
                // redirect to last visited url
                $referer = $request->headers->get('referer');
                return $this->redirect($referer);
            }

            $em = $this->getDoctrine()->getManager();
            $subscriber->setUnsubscribe('0');
            $em->persist($subscriber);
            $em->flush();

            // send mail confirmation
            $MyEmail = (new Email())
                ->from('alexisng90210@gmail.com')
                ->to($email)
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('K-wedition | NewsLetter!')
                ->text('Hello! '.$email.'')
                ->html('<p>MERCI DE FAIRE PARTI DE <a href="https://k-wedition.com">K-WEDITION</a> </p>');
            $mailer->send($MyEmail);

            $this->addFlash('success','vous etes maintenant souscrit, un mail vous a ete envoye');

        }
        return $this->render('public_template/subscribe.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
