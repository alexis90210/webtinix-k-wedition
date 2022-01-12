<?php

namespace App\Controller;

use App\Entity\KanbanManga;
use App\Entity\KanbanUser;
use App\Form\KanbanAdminType;
use App\Form\SearchBarType;
use Doctrine\DBAL\DriverManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class KanbanSearchController extends AbstractController
{
    /*#[Route('/recherche', name: 'search')]
    public function index(Request $request): Response
    {
        $attrs = ['driver' => 'pdo_mysql', 'host' => 'localhost', 'dbname' => 'webtinix_kanban',
            'port' => 5432, 'user' => 'alexis', 'password' => 'Black1234@'];

        $conn = DriverManager::getConnection($attrs);
        $queryBuilder = $conn->createQueryBuilder();

        $form = $this->createForm(SearchBarType::class);
        $form->handleRequest($request);
        $key ='';
        $mangas = [];
        if ($form->isSubmitted() && $form->isValid())
        {

            $key = htmlspecialchars(strtolower($form['search']->getData()));
            $extract_keys = explode(' ',$key);

            $condition = "";
            foreach ($extract_keys as $x => $v)
            {
                $v = htmlspecialchars(htmlentities($v));
                $condition .= (strlen($condition) > 0 ? ' OR ' : '') . ' (u.titre_manga LIKE "%' . $v . '%" OR c.titre_chapitre LIKE "%' . $v . '%"' . (is_int($v) ? ' OR p.dernier_chapitre = ' . $v : '') . ') ';
            }
            $mangas = $queryBuilder
                ->select('u.manga_cover,u.id_manga','u.titre_manga','p.dernier_chapitre, c.titre_chapitre')
                ->from('kanban_manga', 'u')
                ->Join('u', 'kanban_manga_nouveaute', 'p', 'u.id_manga = p.id_manga')
                ->Join('u', 'kanban_chapitre', 'c', 'u.id_manga = c.id_manga')
                ->where($condition)
                //->getSQL()
                ->execute()
                ->fetchAllAssociative()
            ;
            //dd($mangas);
        }
        return $this->render('public_template/search.html.twig', [
            'form'=>$form->createView(), 'results'=>$mangas,'motCle'=>$key]);
    }*/

    #[Route('/recherche-key',methods: 'GET', name:'search')]
    public function f(Request $request, Session $session) : Response
    {

        $key = strtolower($_GET['q']);

        $attrs = $session->get('attrs');
            
        $conn = DriverManager::getConnection($attrs);
        $queryBuilder = $conn->createQueryBuilder();

        $mangas = [];

        $extract_keys = explode(' ',$key);

        $condition = "";
        foreach ($extract_keys as $x => $v)
        {
            $v = htmlspecialchars(htmlentities($v));
            $condition .= (strlen($condition) > 0 ? ' OR ' : '') . ' (u.titre_manga LIKE "%' . $v . '%" OR c.titre_chapitre LIKE "%' . $v . '%"' . (is_int($v) ? ' OR p.dernier_chapitre = ' . $v : '') . ') ';
        }
        $mangas = $queryBuilder
            ->select('u.manga_cover,u.id_manga','u.titre_manga','p.dernier_chapitre, c.titre_chapitre')
            ->from('kanban_manga', 'u')
            ->Join('u', 'kanban_manga_nouveaute', 'p', 'u.id_manga = p.id_manga')
            ->Join('u', 'kanban_chapitre', 'c', 'u.id_manga = c.id_manga')
            ->where($condition)
            ->execute()
            ->fetchAllAssociative()
        ;
        if (empty($mangas))
        {
            $this->addFlash('empty_result','Aucun resultat trouve pour ('.$key.')');
            // redirect to last visited url
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);

        }


        return $this->render('public_template/search.html.twig', [
        'results'=>$mangas,'motCle'=>$key]);
    }

}
