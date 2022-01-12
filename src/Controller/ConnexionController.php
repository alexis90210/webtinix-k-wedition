<?php

namespace App\Controller;

use App\Entity\KanbanUser;
use App\Form\ConnexionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;


class ConnexionController extends AbstractController
{

   #[Route('/connexion', name: 'connexion')]
    public function register(Request $request, Session $session): Response
    {
        $confirmation = $session->get('confirmationSucccess');
        $memberKanban = new KanbanUser();
        $form = $this->createForm(ConnexionType::class,$memberKanban);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $req = $this->getDoctrine()->getManager();
            $email = $form['email']->getData();
            $password = $form['password']->getData();

            $MemberExists = $this->getDoctrine()
                ->getRepository(KanbanUser::class)
                ->findOneBy(array(
                    'email' => $email
                    ));
            if (empty($MemberExists))
            {
                    $this->addFlash('success','ce compte n\'existe pas');
            }
            else if ( (password_verify($password,$MemberExists->getPassword()) == true) )
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

               if ('1' == $MemberExists->getVerifieEmail())
               {
                   if ($MemberExists->getAdmin() == 'ADMIN')
                   {
                       $session->set('admin_role',true);
                       $session->set('admin_role_name',$MemberExists->getPseudo());
                       $session->set('admin_role_id',$MemberExists->getId());
                       $session->set('admin_role_email',$email);
                       $session->set('member_logged_avatar',$MemberExists->getAvatar());

                       return $this->redirectToRoute('admin');
                   } else {

                       $session->set('member_logged',true);
                       $session->set('member_logged_id',$MemberExists->getId());
                       $session->set('member_logged_pseudo',$MemberExists->getPseudo());
                       $session->set('member_logged_email',$email);
                       $session->set('member_logged_avatar',$MemberExists->getAvatar());
                       $session->set('member_logged_password',$password);

                       return $this->redirect('/');
                   }

               }
               else{
                   $this->addFlash('success','Votre n\'est pas encore active, veuillez l\'activer, puis connectez-vous , consultez votre boite mail ');
               }
            }
            else {
                $this->addFlash('success','Idientifiants incorrects');
            }
        }

        return $this->render('public_template/login.html.twig',[
            'form' => $form->createView(),
            'confirmationSucccess' => $confirmation
            ]);

    }

}
