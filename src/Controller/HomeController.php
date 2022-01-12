<?php

namespace App\Controller;

use App\Entity\KanbanLike;
use App\Entity\KanbanManga;
use App\Entity\KanbanUser;
use App\Entity\KanbanCommentaire;
use App\Form\InscriptionType;
use App\Form\SearchBarType;
use App\Repository\KanbanChapitreRepository;
use App\Repository\KanbanInfoCulturelleRepository;
use App\Repository\KanbanMangaRepository;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use function Composer\Autoload\includeFile;

class HomeController extends AbstractController
{
    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    #[Route('/', name: 'home')]
    public function index(Session $session): Response
    {
        $attrs = ['driver' => 'pdo_mysql', 'host' => 'localhost', 'dbname' => 'webtinix_kanban',
            'port' => 5432, 'user' => 'alexis', 'password' => 'Black1234@'];

        $session->set('attrs',$attrs);

        $conn = DriverManager::getConnection($attrs);
        $queryBuilder = $conn->createQueryBuilder();

        $chapitres = $queryBuilder
            ->select("u.image,u.titre_chapitre,u.id, u.status_chapitre , u.numero_chapitre, u.date_sortie_chapitre,u.date_fin_chapitre, p.titre_manga, p.id_manga, ( SELECT COUNT(commentaire) FROM kanban_commentaire WHERE kanban_commentaire.id_chapitre = u.id ) AS 'NbreCommentaire',  ( SELECT COUNT(like_chapitre) FROM kanban_like WHERE kanban_like.id_chapitre = u.id ) AS 'NbreLike'")
            ->from('kanban_chapitre','u' )
            ->Join('u', 'kanban_manga', 'p', 'p.id_manga = u.id_manga')
            ->orderBy("p.id_manga",'DESC LIMIT 200')
            ->where("u.status_chapitre = 'Termine'")
            ->execute()
            ->fetchAllAssociative()
            ;

        // ----------------------------------------------------------

        $conn2 = DriverManager::getConnection($attrs);
        $queryBuilder = $conn2->createQueryBuilder();

        $chapitresEncours = $queryBuilder
            ->select("u.image,u.titre_chapitre,pl.progres_chapitre,u.id, u.numero_chapitre, u.date_sortie_chapitre,u.date_fin_chapitre, p.titre_manga")
            ->from('kanban_chapitre','u' )
            ->Join('u', 'kanban_manga', 'p', 'p.id_manga = u.id_manga')
            ->Join('u', 'kanban_planning', 'pl', 'pl.id_chapitre = u.id')
            ->where("status_chapitre = 'En cours'")
            ->andWhere(" pl.progres_chapitre != '100'")
            ->orderBy("p.id_manga",'DESC LIMIT 5')
            ->execute()
            ->fetchAllAssociative()
        ;
        //dd($chapitresEncours);

        $conn2 = DriverManager::getConnection($attrs);
        $queryBuilder = $conn2->createQueryBuilder();

        $chapitresTermine = $queryBuilder
            ->select("( SELECT COUNT(commentaire) FROM kanban_commentaire WHERE kanban_commentaire.id_chapitre = u.id ) AS 'NbreCommentaire',  ( SELECT COUNT(like_chapitre) FROM kanban_like WHERE kanban_like.id_chapitre = u.id ) AS 'NbreLike',p.id_manga,u.image, u.titre_chapitre, pl.progres_chapitre,u.id, u.numero_chapitre, u.date_sortie_chapitre,u.date_fin_chapitre, p.titre_manga")
            ->from('kanban_chapitre','u' )
            ->Join('u', 'kanban_manga', 'p', 'p.id_manga = u.id_manga')
            ->Join('u', 'kanban_planning', 'pl', 'pl.id_chapitre = u.id')
            ->where("status_chapitre = 'Termine'")
            ->orWhere("pl.progres_chapitre = '100'")
            ->orderBy("p.id_manga",'DESC LIMIT 10')
            ->execute()
            ->fetchAllAssociative()
        ;

        // -----------------------------------------------------------

        $session->set('chapitres',$chapitres);

        if (empty($session->get('member_logged')) || empty($session->get('admin_role'))){
            $auth = false;
        } else{
            $auth = true;
        }

        // ------------------------------------------------------
        // for carousel

        $conn3 = DriverManager::getConnection($attrs);
        $queryBuilder = $conn3->createQueryBuilder();

        $carouselImages = $queryBuilder
            ->select("c.id as id_car, c.id_scan, s.scan_images, s.id_chapitre, ch.id_manga")
            ->from('carousel','c' )
            ->Join('c', 'kanban_scan', 's', 's.id = c.id_scan')
            ->Join('c', 'kanban_chapitre', 'ch', 'ch.id = s.id_chapitre')
            ->orderBy("c.id",'DESC LIMIT 2')
            ->execute()
            ->fetchAllAssociative()
        ;
        $pic = array();
        $picIdManga = array();
        foreach ($carouselImages as $k)
        {
            $pic[] = $k['scan_images'];
            $picIdManga[] = $k['id_manga'];
        }

        // THIS IS A WEB SERVICE FOR PROGRESS BAR UPDATE

        $conn4 = DriverManager::getConnection($attrs);
        $queryBuilder = $conn4->createQueryBuilder();

        $dates = $queryBuilder
            ->select("c.id , c.date_sortie_chapitre, c.date_fin_chapitre, c.id_manga")
            ->from('kanban_chapitre','c' )
            ->execute()
            ->fetchAllAssociative()
        ;

        foreach ($dates as $date => $day)
        {
            //dd($day);
            $debut = $day['date_sortie_chapitre'];
            $fin = $day['date_fin_chapitre'];

            // debut
            $debut_tab = explode('/',$debut);
            $debut_jour = intval($debut_tab[0]);
            $debut_mois = intval($debut_tab[1]);
            $debut_annee = intval($debut_tab[2]);

            //fin
            $fin_tab = explode('/',$fin);
            $fin_jour = intval($fin_tab[0]);
            $fin_mois = intval($fin_tab[1]);
            $fin_annee = intval($fin_tab[2]);

            // date aujourd'hui
            $aujourd_hui = date("d/m/y");
            $aujourd_hui_tab = explode('/',$aujourd_hui);
            $aujourd_hui_jour = intval($aujourd_hui_tab[0]);
            $aujourd_hui_mois = intval($aujourd_hui_tab[1]);
            $aujourd_hui_annee = intval($aujourd_hui_tab[2]);

            // operation debut et fin
            $total_duree_du_projet = abs(($debut_jour-$fin_jour)) + abs(($debut_mois-$fin_mois))*31+abs(($debut_annee-$fin_annee))*365;

            $total_duree_ecoulee = abs(($debut_jour-$aujourd_hui_jour)) + abs(($debut_mois-$aujourd_hui_mois))*31+abs(($debut_annee-$aujourd_hui_annee))*365;

            $pourcentage = ($total_duree_ecoulee * 100) / $total_duree_du_projet;

            $em = $this->getDoctrine()->getManager();

            if ($pourcentage >= 100) {  $pourcentage = 100;   }

            $raw_query = "UPDATE kanban_planning SET progres_chapitre = " . $pourcentage . " WHERE id_manga = " . intval($day['id_manga']) . " AND id_Chapitre = " . intval($day['id']) . ";";
            $stm = $em->getConnection()->prepare($raw_query);
            $stm->execute();

            // on se rassure aue le chapitre est toujour en cours tant que le
            // pourcentage est inferieur a 100
            // donc meme si l'admin modifie la date de fin en retard le chapitre termine sera
            // automatiquement remis en cours et chasse de la rubrique chapitre termine pour revenir
            // a la rubrique chapitre en cours


            if ($pourcentage < 100) {

                $raw_query = "UPDATE kanban_planning SET progres_chapitre = " . $pourcentage . " WHERE id_manga = " . intval($day['id_manga']) . " AND id_Chapitre = " . intval($day['id']) . ";";
                $stm = $em->getConnection()->prepare($raw_query);
                $stm->execute();

                $raw_query = "UPDATE kanban_chapitre SET status_chapitre = '" . 'En cours' . "' WHERE id_manga = " . intval($day['id_manga']) . " AND id = " . intval($day['id']) . ";";
                $stm = $em->getConnection()->prepare($raw_query);
                $stm->execute();
            }

        }

        /// END

        /// NEW SERVICE TO SET FOROM CHAPITRE EN COURS TO TERMINE

        $conn6 = DriverManager::getConnection($attrs);
        $queryBuilder = $conn6->createQueryBuilder();

        // check if il y'a un chapitre a 100%
        $progress_value_100 = $queryBuilder
            ->select("c.id_chapitre, c.progres_chapitre")
            ->from('kanban_planning','c' )
            ->where("c.progres_chapitre LIKE '100'")
            ->execute()
            ->fetchAllAssociative()
        ;


       if (!empty($progress_value_100))
       {
           foreach ($progress_value_100 as $k)
           {
                $em = $this->getDoctrine()->getManager();
                $query ="UPDATE kanban_chapitre SET status_chapitre = '".'Termine'."' WHERE id = ".intval($k['id_chapitre']).";";

                $stm = $em->getConnection()->prepare($query);
                $stm->execute();

           }
       }

        /// END

        return $this->render('public_template/index.html.twig' ,[
          // 'chapitres'=> $chapitres,
           'chapitreEncours' => $chapitresEncours,
           'chapitreTermine' => $chapitresTermine,
           'member_logged' => $auth,
            'pic1'=> $pic[0],
            'pic1IdManga' => $picIdManga[0],
            'pic2' => $pic[1],
            'pic2IdManga' => $picIdManga[1],
        ]);
    }


}
