<?php

namespace App\Controller;

use App\Form\SearchBarType;
use Doctrine\DBAL\DriverManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class KanbanPlanController extends AbstractController
{
    #[Route('/plan', name: 'plan')]
    public function index(Request $request,Session $session): Response
    {
        $attrs = $session->get('attrs');
            
        $conn = DriverManager::getConnection($attrs);
        $queryBuilder = $conn->createQueryBuilder();

        $chapitresEncours = $queryBuilder
            ->select("u.image,u.titre_chapitre,pl.progres_chapitre,u.id, u.numero_chapitre, u.date_sortie_chapitre,u.date_fin_chapitre, p.titre_manga, p.id_manga")
            ->from('kanban_chapitre','u' )
            ->Join('u', 'kanban_manga', 'p', 'p.id_manga = u.id_manga')
            ->Join('u', 'kanban_planning', 'pl', 'pl.id_chapitre = u.id')
            ->where("status_chapitre = 'En cours'")
            ->orderBy("p.id_manga",'DESC LIMIT 300')
            ->execute()
            ->fetchAllAssociative()
        ;

        $conn4 = DriverManager::getConnection($attrs);
        $queryBuilder = $conn4->createQueryBuilder();

        $dates = $queryBuilder
            ->select("c.id , manga.titre_manga, c.date_sortie_chapitre, c.numero_chapitre, c.date_fin_chapitre, c.id_manga")
            ->from('kanban_chapitre','c' )
            ->join('c','kanban_manga','manga','manga.id_manga = c.id_manga')
            ->execute()
            ->fetchAllAssociative()
        ;

        //dd($dates);
        $data = array();

        foreach ($dates as $day)
        {
            $fin = $day['date_fin_chapitre'];

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

            // ecrire le mois en lettre
            switch ($aujourd_hui_mois){
                case 1 : $mois ='Janvier';break;
                case 2 : $mois ='Fevrier';break;
                case 3 : $mois ='Mars';break;
                case 4 : $mois ='Avril';break;
                case 5 : $mois ='Mai';break;
                case 6 : $mois ='Juin';break;
                case 7 : $mois ='Juillet';break;
                case 8 : $mois ='Aout';break;
                case 9 : $mois ='Septembre';break;
                case 10 : $mois ='Octobre';break;
                case 11 : $mois ='Novembre';break;
                case 12: $mois ='Decembre';break;
                default:break;
            }

            $mois_annee = $mois." ".$aujourd_hui_annee;

            // date complet en lettre
            $dateComplet = $aujourd_hui_jour. " " . $mois . " ".$aujourd_hui_annee;

            if ($fin_annee == $aujourd_hui_annee)
            {
                if ($fin_mois == $aujourd_hui_mois)
                {
                    $data[] = array(
                        'jour' =>$fin_jour,
                        'mois' => $fin_mois,
                        'annee'=> $aujourd_hui_annee,
                        'titre' => $day['titre_manga'],
                        'numero' => $day['numero_chapitre']
                    );
                }
            }



        }
        //dd($data);
        /// END


        return $this->render('public_template/plan.html.twig', [
            'mangas' => $chapitresEncours,
            'datas' => $data,
            'mois_annee' =>$mois_annee,
            'date_complet'=>$dateComplet
        ]);
    }
}
