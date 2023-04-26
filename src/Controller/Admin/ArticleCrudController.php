<?php
namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id');
        yield TextField::new('nom');
        yield TextareaField::new('description');
        // yield ImageField::new('image')
        //     ->setBasePath('upload/images/articles')
        //     ->setUploadDir('public/upload/images/articles')
        //     ->setFormType(ImageType::class);
    }
    
}





