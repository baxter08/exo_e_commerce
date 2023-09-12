<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\Devis;
use App\Entity\Panier;
use App\Entity\Commande;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator){}
    
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
       
        return $this->render('admin/dashboard.html.twig');
         
    }

    public function configureDashboard(): Dashboard
    {
   return Dashboard::new()
        ->setTitle('Sécurité +');


    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Tableau de bord', 'fa fa-home', $this->generateUrl('admin'));
        
        yield MenuItem::section('Utilisateurs');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter un utilisateur', 'fa fa-plus', User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Consulter utilisateurs', 'fa fa-eye', User::class)
        ]);

        yield MenuItem::section('Articles');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter un article', 'fa fa-plus', Article::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Consulter articles', 'fa fa-eye', Article::class)
        ]);
        yield MenuItem::linkToCrud('Article', 'fa fa-user', Article::class);
       
        yield MenuItem::linkToCrud('Devis', 'fa fa-user', Devis::class);
        
    }

}
