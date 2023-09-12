<?php

namespace App\Controller\Admin;

use App\Entity\Devis;
use App\Util\PdfUtil;
use App\Repository\DevisRepository;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DevisCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Devis::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            TextField::new('prenom'),
            EmailField::new('email'),
            TelephoneField::new('telephone'),
            TextareaField::new('description_travaux'),
           

            AssociationField::new('user', 'Utilisateur')
        ];
    }

    public function genererDevis(AdminContext $context, DevisRepository $devisRepo) {
        if(!$this->isGranted("ROLE_SUPER_ADMIN")) {
            return new Response('Interdit', 403);
        }
        
        $devisId = $context->getRequest()->query->get('entityId');
        $devis = $devisRepo->find($devisId);
        
        $pdfContent = PdfUtil::genererDevis($devis);

        $response = new Response(
            $pdfContent,
            Response::HTTP_OK,
            ['content-type' => 'application/pdf']
        );
        return $response;

    }

    public function configureActions(Actions $actions): Actions
    {
        $devisAction = Action::new('generer_devis')
            ->setIcon('fa fa-eye')
            ->setLabel('Télécharger le devis')
            ->setHtmlAttributes(['target' => '_blank'])
            ->linkToCrudAction('genererDevis');

        return $actions->add(Crud::PAGE_INDEX, $devisAction);
    }

}
