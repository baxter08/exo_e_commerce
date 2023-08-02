<?php

namespace App\Controller\Admin;

use App\Entity\Panier;
use App\Entity\Cart;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class PanierCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Panier::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('user'),
            TextField::new('article'),
            NumberField::new('quantite'),
        ];
    }
}
