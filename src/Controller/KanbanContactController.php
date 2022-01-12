<?php

namespace App\Controller;

use App\Entity\KanbanContactUs;
use App\Entity\KanbanSubscriber;
use App\Entity\KanbanUser;
use App\Form\KanbanContactUsType;
use App\Form\KanbanSubscriberType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class KanbanContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request,  MailerInterface $mailer): Response
    {
        $contactUs = new KanbanContactUs();
        $form = $this->createForm(KanbanContactUsType::class,$contactUs);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $email = $form['email']->getData();
            $sujet = $form['sujet']->getData();
            $message = $form['message']->getData();

            $doublonExists = $this->getDoctrine()
                ->getRepository(KanbanContactUs::class)
                ->findOneBy(array(
                    'email' => $email,
                    'sujet' => $sujet,
                    'message' => $message
                ));

            if (!empty($doublonExists))
            {
                $this->addFlash('success','Message deja envoye');
                // redirect to last visited url
                $referer = $request->headers->get('referer');
                return $this->redirect($referer);
            }

            $em = $this->getDoctrine()->getManager();
            $contactUs->setDateDenvoi(date('j-n-Y, H:i:s'));
            $em->persist($contactUs);
            $em->flush();


            // send mail confirmation
            $MyEmail = (new Email())
                ->from('alexisng90210@gmail.com')
                ->to($email)
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('K-wedition | Assistant!')
                ->text('Hello! '.$email.'')
                ->html('<p>Merci d\'avoir contacter <a href="http://k-wedition.com"> k-wedition</a> , Nous vous repondrons le plus tot possible</p>');
            $mailer->send($MyEmail);

            $this->addFlash('success','Message envoye avec succes, un mail vous a ete envoye en confirmation');

        }

        return $this->render('public_template/contact.html.twig', [  'form' => $form->createView() ]);
    }
}
