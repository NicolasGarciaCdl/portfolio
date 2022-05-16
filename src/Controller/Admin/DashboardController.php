<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Language;
use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/Dashboard.html.twig');
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Portfolio - Administration');
    }

    /**
     * @return iterable
     * Affiche les menus dans la side-bar
     */
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Retour au site', 'fas fa-link', 'app_home');
        yield MenuItem::linkToDashboard('Tableau de Bord', 'fa fa-home');
        yield MenuItem::subMenu('Réalisations', 'fa-solid fa-folder-open')->setSubItems([
            MenuItem::linkToCrud('Tous les projets', 'fas fa-newspaper', Project::class),
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Project::class)->setAction(Crud::PAGE_NEW),
        ]);
        yield MenuItem::linkToCrud('Langage', 'fas fa-list', Language::class);
        yield MenuItem::subMenu('Articles', 'fas fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Tous les Articles', 'fas fa-newspaper', Article::class),
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Article::class)->setAction(Crud::PAGE_NEW),

        ]);
        yield MenuItem::subMenu('Commentaires', 'fas fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Tous les commentaires', 'fas fa-comments', Comment::class)
        ]);
    }
}
