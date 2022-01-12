<?php

namespace App\Controller;

use App\Entity\KanbanChapitre;
use App\Entity\KanbanManga;
use App\Entity\KanbanScan;
use App\Entity\KanbanUser;
use App\Form\AjouterUnChapitreType;
use App\Form\AjouterUnMangaType;
use App\Form\AjouterUnScanType;
use App\Form\EditUnChapitreType;
use App\Form\EditUnMangaType;
use App\Form\fileUploaderType;
use App\Repository\AdminActionsRepository;
use App\Repository\KanbanChapitreRepository;
use App\Repository\KanbanMangaRepository;
use App\Repository\KanbanScanRepository;
use App\Repository\KanbanUserRepository;
use App\service\fileUploader;
use Doctrine\DBAL\DriverManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class DashbordController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(Session $session, AdminActionsRepository $actions): Response
    {
        if ($session->get('admin_role') != true)
        {
            return $this->redirect('/');
        }
        //dd($actions->findAll());

            return $this->render('private_template/index.html.twig', ['actions'=>$actions->findAll()]);
    }

    #[Route('/gestion-membre', name: 'gestion_membre')]
    public function i(KanbanUserRepository $users, Session $session): Response
    {
        if ($session->get('admin_role') != true)
        {
            return $this->redirect('/');
        }
        return $this->render('private_template/list_user.html.twig',
            ['membres' => $users->findBy(array('MembreBanni'=>'0')),
             'total' => count($users->findBy(array('MembreBanni'=>'0')))-1
            ]);
    }

    #[Route('/poster-manga', name: 'poster_manga')]
    public function n(Session $session, Request $request ,fileUploader $file_uploader): Response
    {
        if ($session->get('admin_role') != true)
        {
            return $this->redirect('/');
        }

        $form = $this->createForm(AjouterUnMangaType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $titre_manga = $form['titre_manga']->getData();
            $auteur = $form['auteur']->getData();
            $genre = $form['genre']->getData();
            $decouverte = $form['decouverte']->getData();
            $status_manga = $form['status_manga']->getData();
            $titre_chapitre = $form['titre_chapitre']->getData();
            $numero_chapitre = $form['numero_chapitre']->getData();
            $date_fin = $form['date_fin']->getData();
            $description = $form['description']->getData();
            $status_chapitre = $form['status_chapitre']->getData();

            // this is empty , file not got uploaded yet
            $upload_file = $form['upload_scan']->getData();
            $manga_cover = $form['manga_cover']->getData();
            $profile_manga = $form['profile_manga']->getData();
            $cover_chapitre = $form['image']->getData();

            //check if num chapitre already exists
            $attrs = $session->get('attrs');
            
            $conn = DriverManager::getConnection($attrs);
            $queryBuilder = $conn->createQueryBuilder();

            $query = $queryBuilder
                ->select("u.titre_chapitre , u.numero_chapitre, p.titre_manga")
                ->from('kanban_chapitre','u' )
                ->Join('u', 'kanban_manga', 'p', 'p.id_manga = u.id_manga')
                ->where("u.numero_chapitre = :num")
                ->andWhere("p.titre_manga = :titre")
                ->setParameters(array(
                    'num'=> $numero_chapitre,
                    'titre' => $titre_manga
                ))
                ->execute()
                ->fetchAssociative()
            ;

            if ($query == false)
            {

                // start uploading scan
                if ($upload_file)
                {
                    $file_name = $file_uploader->upload($upload_file);
                    // file as been uploaded , now check public/uploads to see it

                    if (null != $file_name)
                    {
                        // this is dir of uploaded scan
                        $directory = $file_uploader->getTargetDirectory();
                        $scan_full_path = $directory.'/'. $file_name;  // this is url of uploaded scan

                        // start uploading cover
                        if ($manga_cover)
                        {
                            $file_name_cover = $file_uploader->upload($manga_cover);
                            // file as been uploaded , now check public/uploads to see it

                            if (null != $file_name_cover)
                            {
                                // this is dir of uploaded scan
                                $directory = $file_uploader->getTargetDirectory();
                                $full_path_cover = $directory.'/'. $file_name_cover;  // this is url of uploaded scan

                                // start uploading profile
                                if ($profile_manga)
                                {
                                    $file_name_profile = $file_uploader->upload($profile_manga);
                                    // file as been uploaded , now check public/uploads to see it

                                    if (null != $file_name_profile)
                                    {
                                        // this is dir of uploaded scan
                                        $directory = $file_uploader->getTargetDirectory();
                                        $full_path_profile = $directory.'/'. $file_name_profile;  // this is url of uploaded scan

                                        if ($cover_chapitre)
                                        {
                                            $file_name_cover_chap = $file_uploader->upload($cover_chapitre);
                                            // file as been uploaded , now check public/uploads to see it

                                            if (null != $file_name)
                                            {
                                                $directory = $file_uploader->getTargetDirectory();
                                                $full_path = $directory.'/'. $file_name_cover_chap;
                                                $session->set('file',$cover_chapitre);


                                                // now we can start proccessing to table insertion
                                                $em = $this->getDoctrine()->getManager();
                                                $now = date("d/m/y");
                                                $raw_query = "INSERT INTO kanban_manga (titre_manga,manga_post_at,status_manga,type_manga,auteur_manga,manga_cover,manga_profile,decouverte) VALUES('".$titre_manga."','".$now."','".$status_manga."','".$genre."','".$auteur."', '".$file_name_cover."','".$file_name_profile."',".$decouverte.")";
                                                $raw_query1 ='INSERT INTO kanban_chapitre (titre_chapitre,id_manga, numero_chapitre, date_sortie_chapitre,status_chapitre, description, date_fin_chapitre,image) VALUES("'.htmlspecialchars($titre_chapitre).'", (SELECT MAX(id_manga) FROM kanban_manga),'.$numero_chapitre.',"'.$now.'","'.$status_chapitre.'","'.$description.'","'.$date_fin.'","'.$file_name_cover_chap.'")';
                                                $raw_query2 ="INSERT INTO kanban_manga_nouveaute (id_manga, dernier_chapitre) VALUES ((SELECT MAX(id_manga) FROM kanban_manga),".$numero_chapitre.");";
                                                $raw_query3 ="INSERT INTO kanban_manga_genre (id_manga, genre_manga) VALUES ((SELECT MAX(id_manga) FROM kanban_manga),'".$genre."');INSERT INTO kanban_scan (id_chapitre, scan_images, id_manga) VALUES ((SELECT MAX(id) FROM kanban_chapitre),'".$file_name."',(SELECT MAX(id_manga) FROM kanban_manga))";
                                                $raw_query4 = "INSERT INTO kanban_planning (id_chapitre,progres_chapitre,id_manga) VALUES((SELECT MAX(id) FROM kanban_chapitre),'".'0'."',(SELECT MAX(id_manga) FROM kanban_manga));";

                                                $stm = $em->getConnection()->prepare($raw_query);
                                                $stm->execute()->close();

                                                $stm1 = $em->getConnection()->prepare($raw_query1);
                                                $stm1->execute()->close();

                                                $stm2 = $em->getConnection()->prepare($raw_query2);
                                                $stm2->execute()->close();

                                                $stm3 = $em->getConnection()->prepare($raw_query3);
                                                $stm3->execute()->close();

                                                $stm4 = $em->getConnection()->prepare($raw_query4);
                                                $stm4->execute();

                                                $des = "manga : ".$titre_manga;
                                                $des .= " - chapitre : ".$numero_chapitre;
                                                $des .= " - ".$titre_chapitre;
                                                $des .= " a bien ete ajoute";
                                                $this->addFlash('success',$des);


                                                $now = date("d/m/y");
                                                $action_description = "Vous avez ajoute un manga<br>Titre :".$titre_manga."<br>Titre chapitre : ".$titre_chapitre;

                                                $actionQuery = "INSERT INTO admin_actions (description, date_action) VALUES ('".$action_description."', '".$now."')";

                                                $stm5 = $em->getConnection()->prepare($actionQuery);
                                                $stm5->execute();

                                                // redirect to last visited url
                                                $referer = $request->headers->get('referer');
                                                return $this->redirect($referer);

                                            }
                                            else{
                                                return new Response('error veuillez reessayer');
                                            }
                                        }

                                    }
                                    else{
                                        return new Response('error veuillez reessayer');
                                    }
                                } // end
                            }
                            else{
                                return new Response('error veuillez reessayer');
                            }
                        }
                    }
                    else{
                        return new Response('error veuillez reessayer');
                    }
                }
            }
            else{
                $this->addFlash('success','ce chapitre est deja en ligne');
            }




        }

        return $this->render('private_template/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/del/{idMembre}', name: 'delete')]
    public function k($idMembre,Session $session, Request $request): Response
    {
        if ($session->get('admin_role')!= true)
        {
            return $this->redirect('/');
        }

        $em = $this->getDoctrine()->getManager();
        $user = new KanbanUser();
        $user_got = $em->getRepository(KanbanUser::class,$user)
            ->findOneBy(array(
                'id' => $idMembre
            ));
        $user_got->setMembreBanni('1');
        $em->flush($user_got);

        $now = date("d/m/y");
        $action_description = "Vous avez banni un membre";

        $actionQuery = "INSERT INTO admin_actions (description, date_action) VALUES ('".$action_description."', '".$now."')";

        $stm5 = $em->getConnection()->prepare($actionQuery);
        $stm5->execute();

        // redirect to last visited url
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    #[Route('/edit-delete/', name: 'modifie')]
    public function j(Session $session,KanbanMangaRepository $mangas, Request $request ,fileUploader $file_uploader): Response
    {
        if ($session->get('admin_role') != true)
        {
            return $this->redirect('/');
        }

        $form = $this->createForm(AjouterUnMangaType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        }
        //dd($mangas->findAll());
        return $this->render('private_template/list_manga.html.twig', [
            'form' => $form->createView(),
            'mangas' => $mangas->findAll()
        ]);

    }

    #[Route('/edit-delete-{idManga}', name: 'chap_manga')]
    public function c( fileUploader $file_uploader,Session $session, KanbanChapitreRepository $chapitres, Request $request , $idManga): Response
    {
        if ($session->get('admin_role') != true)
        {
            return $this->redirect('/');
        }

        $form = $this->createForm(AjouterUnChapitreType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $titre_chapitre = $form['titre_chapitre']->getData();
            $numero_chapitre = $form['numero_chapitre']->getData();
            $date_fin = $form['date_fin']->getData();
            $description = $form['description']->getData();
            $status_chapitre = $form['status_chapitre']->getData();

            // this is empty , file not got uploaded yet
            $upload_file = $form['upload_scan']->getData();
            $chapitre_cover = $form['image']->getData();

            //check if num chapitre already exists
            $attrs = $session->get('attrs');
            
            $conn = DriverManager::getConnection($attrs);
            $queryBuilder = $conn->createQueryBuilder();

            $query = $queryBuilder
                ->select("u.titre_chapitre , u.numero_chapitre, p.titre_manga")
                ->from('kanban_chapitre','u' )
                ->Join('u', 'kanban_manga', 'p', 'p.id_manga = u.id_manga')
                ->where("u.numero_chapitre = :num")
                ->where("u.titre_chapitre = :titre")
                ->setParameters(array(
                    'num'=> $numero_chapitre,
                    'titre' => $titre_chapitre
                ))
                ->execute()
                ->fetchAssociative()
            ;

            if ($query == false)
            {

                // start uploading scan
                if ($upload_file)
                {
                    $file_name = $file_uploader->upload($upload_file);
                    // file as been uploaded , now check public/uploads to see it

                    if (null != $file_name)
                    {
                        // this is dir of uploaded scan
                        $directory = $file_uploader->getTargetDirectory();
                        $scan_full_path = $directory.'/'. $file_name;  // this is url of uploaded scan


                        if ($chapitre_cover)
                        {
                            $file_name_cover_chap = $file_uploader->upload($chapitre_cover);
                            // file as been uploaded , now check public/uploads to see it

                            if (null != $file_name_cover_chap)
                            {
                                $directory = $file_uploader->getTargetDirectory();
                                $full_path = $directory.'/'. $file_name_cover_chap;


                                // now we can start proccessing to table insertion
                                $em = $this->getDoctrine()->getManager();
                                $now = date("d/m/y");
                                $raw_query1 ='INSERT INTO kanban_chapitre (titre_chapitre,id_manga, numero_chapitre, date_sortie_chapitre,status_chapitre, description, date_fin_chapitre,image) VALUES("'.htmlspecialchars($titre_chapitre).'",'.$idManga.','.$numero_chapitre.',"'.$now.'","'.$status_chapitre.'","'.$description.'","'.$date_fin.'","'.$file_name_cover_chap.'")';
                                $raw_query2 ="UPDATE kanban_manga_nouveaute SET dernier_chapitre= ".$numero_chapitre." WHERE id_manga = $idManga;";
                                $raw_query3 ="INSERT INTO kanban_scan (id_chapitre, scan_images, id_manga) VALUES ((SELECT MAX(id) FROM kanban_chapitre),'".$file_name."',$idManga)";

                                $stm1 = $em->getConnection()->prepare($raw_query1);
                                $stm1->execute();

                                $stm2 = $em->getConnection()->prepare($raw_query2);
                                $stm2->execute();

                                $stm3 = $em->getConnection()->prepare($raw_query3);
                                $stm3->execute();

                                $init ='0';
                                $raw_query4 ='INSERT INTO kanban_planning (id_chapitre,progres_chapitre,id_manga) VALUES((SELECT MAX(id) FROM kanban_chapitre),"'.$init.'",'.$idManga.')';

                                $stm4 = $em->getConnection()->prepare($raw_query4);
                                $stm4->execute();

                                $des = " chapitre : ".$numero_chapitre;
                                $des .= " - ".$titre_chapitre;
                                $des .= " a bien ete ajoute";
                                $this->addFlash('success',$des);

                                $action_description = "Vous avez mis a jour le manga ayant l ID = ".$idManga;
                                $action_description .= "<br>Chapitre : ".$numero_chapitre." <br>";
                                $action_description .= "titre : ".$titre_chapitre;

                                $actionQuery = "INSERT INTO admin_actions (description, date_action) VALUES ('".$action_description."', '".$now."')";

                                $stm5 = $em->getConnection()->prepare($actionQuery);
                                $stm5->execute();

                                // redirect to last visited url
                                $referer = $request->headers->get('referer');
                                return $this->redirect($referer);


                            }
                            else{
                                return new Response('error veuillez reessayer');
                            }
                        }


                    }
                    else{
                        return new Response('error veuillez reessayer');
                    }
                }
            }
            else{
                $this->addFlash('success','ce chapitre est deja en ligne');
            }

        }

        return $this->render('private_template/chapitre.html.twig', [
            'form' => $form->createView(),
            'chapitres' => $chapitres->findBy(array('idManga'=>$idManga)),
            'idManga'=>$idManga
        ]);

    }

    #[Route('/scan-{idchap}-{idManga}', name: 'scan_manga')]
    public function d($idManga, fileUploader $file_uploader,Session $session, KanbanScanRepository $scans, Request $request , $idchap): Response
    {
        if ($session->get('admin_role') != true)
        { return $this->redirect('/'); }

        $scan = new KanbanScan();
        $form = $this->createForm(AjouterUnScanType::class,$scan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['ScanImages']->getData();

            if ($file)
            {
                $file_name = $file_uploader->upload($file);
                // file as been uploaded , now check public/uploads to see it

                if (null != $file_name)
                {
                    $directory = $file_uploader->getTargetDirectory();
                    $full_path = $directory.'/'. $file_name;

                    $em = $this->getDoctrine()->getManager();
                    $raw_query = "INSERT INTO kanban_scan (id_chapitre,scan_images,id_manga) VALUES(".$idchap.",'".$file_name."',".$idManga.");";

                    $stm = $em->getConnection()->prepare($raw_query);
                    $stm->execute();

                    $this->addFlash('success','ajouter avec success');

                    $now = date("d/m/y");
                    $action_description = "Vous avez ajoute un scan au manga ayant l ID = ".$idManga.", chapitre ID =".$idchap;

                    $actionQuery = "INSERT INTO admin_actions (description, date_action) VALUES ('".$action_description."', '".$now."')";

                    $stm5 = $em->getConnection()->prepare($actionQuery);
                    $stm5->execute();


                    // redirect to last visited url
                    $referer = $request->headers->get('referer');
                    return $this->redirect($referer);

                }
                else{
                    return new Response('error veuillez reessayer');
                }
            }
        }

        return $this->render('private_template/scan.html.twig', [
            'form' => $form->createView(),
            'scans' => $scans->findBy(array('idChapitre'=>$idchap))
        ]);
    }

    #[Route('/supprimer-scan-{idScan}', name: 'scan_sup')]
    public function g(Session $session,  Request $request , $idScan): Response
    {
        if ($session->get('admin_role') != true)
        {
            return $this->redirect('/');
        }

        $em = $this->getDoctrine()->getManager();
        $getScan = $this->getDoctrine()
            ->getRepository(KanbanScan::class)
            ->findOneBy(array('id' => $idScan));

        $em->remove($getScan);
        $em->flush();
        $this->addFlash('success','supprime avec success');

        $now = date("d/m/y");
        $action_description = "Vous avez supprime un scan";

        $actionQuery = "INSERT INTO admin_actions (description, date_action) VALUES ('".$action_description."', '".$now."')";

        $stm5 = $em->getConnection()->prepare($actionQuery);
        $stm5->execute();

        // redirect to last visited url
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);

    }

    #[Route('/carousel-{idScan}', name:'carousel')]
    public function z(Request $request, $idScan) : Response
    {

       $em = $this->getDoctrine()->getManager();
       $raw_query1 ='INSERT INTO carousel (id_scan) VALUES ('.$idScan.')';

       $now = date("d/m/y");
       $action_description = "Vous avez mis a jour le carousel";

       $actionQuery = "INSERT INTO admin_actions (description, date_action) VALUES ('".$action_description."', '".$now."')";

       $stm5 = $em->getConnection()->prepare($actionQuery);
       $stm5->execute();

       $stm1 = $em->getConnection()->prepare($raw_query1);
       $stm1->execute();

        // redirect to last visited url
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    #[Route('/delete-{idManga}', name:'')]
    public function v(Request $request, $idManga): Response
    {
        $MangaExists = $this->getDoctrine()
            ->getRepository(KanbanManga::class)
            ->findOneBy(array('idManga' => $idManga));

        if (empty($MangaExists))
        {
            // redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);

        } else{

            $em = $this->getDoctrine()->getManager();
            $raw_query = "DELETE FROM kanban_manga WHERE id_manga = ".$idManga.";";
            $raw_query1 = "DELETE FROM kanban_chapitre WHERE id_manga = ".$idManga.";";

            $stm = $em->getConnection()->prepare($raw_query);
            $stm->execute();

            $stm1 = $em->getConnection()->prepare($raw_query1);
            $stm1->execute();

            $this->addFlash('success', 'Manga et chapitre supprime avec success');
            // redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }
    }

    #[Route('supprime-scan-{idChap}', name:'purge_chap')]
    public function vs(Request $request, $idChap): Response
    {
        $chapitreExists = $this->getDoctrine()
            ->getRepository(KanbanChapitre::class)
            ->findOneBy(array('id' => $idChap));

        if (empty($chapitreExists))
        {

            // redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);

        } else{

            $em = $this->getDoctrine()->getManager();
            $raw_query = "DELETE FROM kanban_scan WHERE id_chapitre = ".$idChap.";";
            $raw_query1 = "DELETE FROM kanban_chapitre WHERE id = ".$idChap.";";
            $raw_query2 = "DELETE FROM kanban_planning WHERE id_chapitre = ".$idChap.";";

            $stm = $em->getConnection()->prepare($raw_query);
            $stm->execute();

            $stm1 = $em->getConnection()->prepare($raw_query1);
            $stm1->execute();

            $stm2 = $em->getConnection()->prepare($raw_query2);
            $stm2->execute();

            $this->addFlash('success', 'chapitre et scans supprime avec success');
            // redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        } ///supprime-scan-
    }

    #[Route('edit-chapitre-{idChap}', name:'edit_chap')]
    public function dvs(Request $request, $idChap): Response{

        $form = $this->createForm(EditUnChapitreType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!empty($form['TitreChapitre']->getData()))
            {
                $em = $this->getDoctrine()->getManager();
                $raw_query = "UPDATE kanban_chapitre SET titre_chapitre = '".htmlspecialchars($form['TitreChapitre']->getData())."' WHERE id = ".$idChap.";";

                $stm = $em->getConnection()->prepare($raw_query);
                $stm->execute();
            }

            if (!empty($form['dateFinChapitre']->getData()))
            {
                $em = $this->getDoctrine()->getManager();
                $raw_query = "UPDATE kanban_chapitre SET date_fin_chapitre = '".htmlspecialchars($form['dateFinChapitre']->getData())."' WHERE id = ".$idChap.";";

                $stm = $em->getConnection()->prepare($raw_query);
                $stm->execute();
            }

            if (!empty($form['description']->getData()))
            {
                $em = $this->getDoctrine()->getManager();
                $raw_query = "UPDATE kanban_chapitre SET description = '".htmlspecialchars($form['description']->getData())."' WHERE id = ".$idChap.";";

                $stm = $em->getConnection()->prepare($raw_query);
                $stm->execute();
            }

            $this->addFlash('success','Modifications effectuees');
            // redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }

        return $this->render('private_template/edit_chapitre.html.twig',['form'=>$form->createView()]);

    }


    #[Route('edit-manga-{idManga}', name:'edit_manga_id')]
    public function sz(Request $request, $idManga): Response{

        $form = $this->createForm(EditUnMangaType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!empty($form['titreManga']->getData()))
            {
                $em = $this->getDoctrine()->getManager();
                $raw_query = "UPDATE kanban_manga SET titre_manga = '".htmlspecialchars($form['titreManga']->getData())."' WHERE id_manga = ".$idManga.";";

                $stm = $em->getConnection()->prepare($raw_query);
                $stm->execute();
            }

            if (!empty($form['AuteurManga']->getData()))
            {
                $em = $this->getDoctrine()->getManager();
                $raw_query = "UPDATE kanban_manga SET auteur_manga = '".htmlspecialchars($form['AuteurManga']->getData())."' WHERE id_manga = ".$idManga.";";

                $stm = $em->getConnection()->prepare($raw_query);
                $stm->execute();
            }

            if (!empty($form['statusManga']->getData()))
            {
                // on verifie si tous les chapitres sont termine pour change le statut a termine


                $chapitres = $this->getDoctrine()
                    ->getRepository(KanbanChapitre::class)
                    ->findBy(array('idManga' => $idManga));

                foreach ($chapitres as $chapitre)
                {

                    if (($chapitre->getStatusChapitre() == 'En cours') && ($form['statusManga']->getData() == 'Termine') )
                    {
                        // redirect to last visited url
                        $this->addFlash('success','probleme : impossible de passer a termine alors que certains chapitres du manga sont encore en cours');
                        $referer = $request->headers->get('referer');
                        return $this->redirect($referer);
                    }
                }
                //-----------------------------------

                $em = $this->getDoctrine()->getManager();
                $raw_query = "UPDATE kanban_manga SET status_manga = '".htmlspecialchars($form['statusManga']->getData())."' WHERE id_manga = ".$idManga.";";

                $stm = $em->getConnection()->prepare($raw_query);
                $stm->execute();
            }

            $this->addFlash('success','Modifications effectuees');
            // redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }

        return $this->render('private_template/edit_manga.html.twig',['form'=>$form->createView()]);


    }

}
