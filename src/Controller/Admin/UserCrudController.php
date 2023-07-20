<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use Symfony\Component\Validator\Constraints\NotBlank;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    private $passwordEncoder;


    public function changePassword(User $user, string $newPassword)
    {
        $encodedPassword = $this->passwordEncoder->encodePassword($user, $newPassword);
        $user->setPassword($encodedPassword);
        // Sauvegarder l'utilisateur avec le nouveau mot de passe dans la base de données
        // Exemple : $entityManager->persist($user); $entityManager->flush();
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
            // IdField::new('Id'),
            TextField::new('pseudo'),
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('password'),
            TextField::new('email'),
            ChoiceField::new('roles')->allowMultipleChoices('roles')->setChoices(['Administrateur utilisateur' => 'ROLE_USER','Super Administrateur' => 'ROLE_SUPER_ADMIN']),
            // TextField::new('password')->setFormType(PasswordType::class)->setRequired(true)->setFormTypeOption('constraints', [
            //     new NotBlank(),
            //     new Length(['min' => 6, 'max' => 32]),
            //     new Regex('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,32}$/')
            // ]),
            DateField::new('created_at'),
        ];
    }

    public function configureMenuItems(): iterable
{
    yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');

    yield MenuItem::section('Utilisateurs');
    // yield ChoiceField::new('roles', 'Rôles')
    //     ->allowMultipleChoices()
    //     ->setChoices([
    //         'Administrateur utilisateur' => 'ADMIN_USER',
    //         'Super Administrateur' => 'SUPER_ADMIN',
    //     ]);
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
