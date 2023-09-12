<?php

namespace App\Controller;

use TCPDF;
use DateTime;
use App\Entity\Devis;
use App\Util\PdfUtil;
use App\Entity\Article;
use App\Form\DevisType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DevisController extends AbstractController
{
    /**
     * @Route("/devis", name="devis")
     */
    public function devis(Request $request, EntityManagerInterface $manager, SessionInterface $session): Response
    {
        // Créer le formulaire DevisType
        $form = $this->createForm(DevisType::class);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Le formulaire a été soumis et est valide

            // Avant de générer le Devis
            $aujourdhui = new DateTime();

            // Récupérer les données du formulaire
            $devisData = $form->getData();
            $devis = new Devis();
            $devis->setDateDevis($aujourdhui);
            $devis->setNom($devisData->getNom());
            $devis->setPrenom($devisData->getPrenom());
            $devis->setEmail($devisData->getEmail());
            $devis->setTelephone($devisData->getTelephone());
            $devis->setDescriptionTravaux($devisData->getDescriptionTravaux());
            $user = $this->getUser();
            if($user !== null)
            {
                $devis->setUser($user);
            }

            // Enregistrer l'entité dans la base de données
            $manager->persist($devis);
            $manager->flush();
            
            // Gérer le panier
            $panier = $session->get("panier", []);
            $id = $devis->getId();

            if (!empty($panier[$id])) {
                if ($panier[$id] > 1) {
                    $panier[$id]--;
                } else {
                    unset($panier[$id]);
                }
            }

            // Mettre à jour la session avec le nouveau panier
            $session->set("panier", $panier);

            // Gérer le panier
            $panier = $session->get("panier", []);
            $calcul = count($panier);
            $total = 0;
            $panierInfo = [];
            foreach ($panier as $idArticle => $quantite) {
                // Récupérer l'article à partir de l'ID (vous devez adapter cette partie selon votre structure de base de données)
                $article = $manager->getRepository(Article::class)->find($idArticle);
                //  dd($panier, $total, $calcul, $article);
                if ($article) {
                    $prixUnitaire = $article->getPrix();

                    // Ajouter les informations de l'article au tableau $panierInfo
                    $panierInfo[] = [
                        'nom' => $article->getNom(),
                        'prix_unitaire' => $article->getPrix($prixUnitaire),
                        'quantite' => $quantite,
                    ];
                }
            }

            $devis->setPanierInfo($panierInfo);
            $manager->flush();

            $pdfContent = PdfUtil::genererDevis($devis);

            // Rediriger vers une page de confirmation du devis avec le contenu PDF et les données du devis
            return $this->render('devis/confirmation.html.twig', [
                'pdfContent' => base64_encode($pdfContent),
                'devis' => $devis
            ]);
        }

        // Afficher le formulaire dans le template Twig
        return $this->render('devis/index.html.twig', [
            'form' => $form->createView(),
            'panierLength' => count($session->get("panier", []))
        ]);
    }

}
