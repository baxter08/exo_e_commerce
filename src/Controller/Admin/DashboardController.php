<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\Commande;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator){}
    
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
       // $url = $this->adminUrlGenerator
                //->setController(UserCrudController::class)
               // ->generateUrl();

        //return $this->redirect($url);
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/dashboard.html.twig');
         
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('just do it');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
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
        yield MenuItem::linkToCrud('Commande', 'fa fa-user', Commande::class);
    }
    
}
