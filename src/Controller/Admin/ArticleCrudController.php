<?php
namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Categorie;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

  
    public function configureFields(string $pageName): iterable
    {
        
  
        // yield IdField::new('id');p
        yield TextField::new('nom');
        yield TextareaField::new('description');
        yield TextareaField::new('description2');
        yield TextareaField::new('description3');
        yield TextareaField::new('description4');
        yield TextareaField::new('essentiel');
        // yield AssociationField::new('categories');
        yield NumberField::new('prix');

        // yield AssociationField::new('categories')
        // ->setFormTypeOptions([
        //     'by_reference' => false,
        // ])
        // ->autocomplete()
        // ->setFormTypeOptions([
        //     'class' => 'App\Entity\Categorie',
        //     'choice_label' => 'nom',
        //     'multiple' => true,
        //     'required' => false,
        // ]);

        // yield ImageField::new('image')
        //     ->setBasePath('upload/images/articles')
        //     ->setUploadDir('public/upload/images/articles')
        //     ->setFormType(ImageType::class);
    }
    
}





