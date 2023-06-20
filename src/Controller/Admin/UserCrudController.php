<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }
    public function configureCrud(Crud $crud) : Crud
    {
        return $crud
            ->setEntityLabelInPlural('Utilisateurs') // permet de mettre Utilisateurs au lieu de User dans le Crud Users
            ->setEntityLabelInSingular('Utilisateur');
    }
    public function configureFields(string $pageName,): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('email'),
            DateTimeField::new('created_at'),
            ChoiceField::new('roles', 'Rôles',User::class)->allowMultipleChoices('roles'),
        ];
    }

    public function configureMenuItems(): iterable
{
    yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');

    yield MenuItem::section('Utilisateurs');
    yield ChoiceField::new('roles','Rôles', User::class)->allowMultipleChoices('ROLE_SUPER_ADMIN','ROLE_USER','ROLE_ADMIN');
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
