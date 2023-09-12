<?php

namespace App\Util;

use TCPDF;
use App\Entity\Devis;
use Symfony\Component\String\Slugger\SluggerInterface;

class PdfUtil
{
    public static function genererDevis(Devis $devis) : string
    {
            // Générer le PDF du devis

            $pdf = new TCPDF();
            $pdf->SetMargins(10, 10, 10);
            $pdf->AddPage();

            $panierInfo = $devis->getPanierInfo();

            $dateDuJour = $devis->getDateDevis()->format('d/m/Y'); // Format de la date : jour/mois/année (par exemple : 25/07/2023)

            // Données à afficher en face du logo
            $donnees = 'Sanitaire Sécurité +'; // Le texte à écrire 

            // Chemin vers l'image de logo
            $logoPath = 'build/images/plumberie-logo-removebg-preview.png';

            // Position X et Y pour placer le logo
            $logoX = 72;
            $logoY = 15;

            // Largeur et hauteur du logo (en millimètres)
            $logoWidth = 13;
            $logoHeight = 13;

            // Insérer le logo
            $pdf->Image($logoPath, $logoX, $logoY, $logoWidth, $logoHeight);

            $pdf->SetFont('dejavusans', 'B', 12); // Ajustez la police et la taille selon vos préférences
            // Position X et Y pour placer les données en face du logo
            $donneesX = $logoX + $logoWidth + 2; // Ajustez la valeur 5 pour contrôler l'espace entre le logo et les données
            $donneesY = $logoY + ($logoHeight - $pdf->getStringHeight(12, $donnees)) / 2 + 10; // Ajouter 10 unités en dessous du logo
            $pdf->SetXY($donneesX, $donneesY);
            $pdf->Cell(0, 12, $donnees, 0, 1, 'L');

            $pdf->SetFont('dejavusans', 'B', 14); // Remettre le style normal pour le reste du texte
            $pdf->SetFillColor(255, 193, 7); // Définir la couleur de remplissage
            $pdf->SetXY(10, 30); // Position de la nouvelle ligne de texte (X, Y)
            $pdf->Cell(0, 10, 'Nos coordonnées', 0, 1, 'L', true); // Le texte à écrire avec l'arrière-plan coloré avec true
            $pdf->Ln(3); // Ajouter une marge de 10 unités en dessous du texte de la description des travaux


            $pdf->SetFont('dejavusans', 'B', 11);
            // Mettre en gras pour le nom seulement
            $pdf->Write(5, 'Entreprise: ', '', 0, 'L', false, 0, false, false, 0);
            $pdf->SetFont('dejavusans', '', 11); // Remettre le style normal pour le reste du texte
            $pdf->Write(5, 'EURL GEORGES Jérèmy', '', 0, 'L', true, 0, false, false, 0);

            $pdf->SetFont('dejavusans', 'B', 11);
            // Mettre en gras pour l'e-mail seulement
            $pdf->Write(5, 'Email: ', '', 0, 'L', false, 0, false, false, 0);
            $pdf->SetFont('dejavusans', '', 11); // Remettre le style normal pour le reste du texte
            $pdf->Write(5, 'GEORGE08Jérèmy@gmail.fr', '', 0, 'L', true, 0, false, false, 0);

            $pdf->SetFont('dejavusans', 'B', 11);
            // Mettre en gras pour le Portable seulement
            $pdf->Write(5, 'Portable: ', '', 0, 'L', false, 0, false, false, 0);
            $pdf->SetFont('dejavusans', '', 11); // Remettre le style normal pour le reste du texte
            $pdf->Write(5, '06.81.66.74.74', '', 0, 'L', true, 0, false, false, 0);

            $pdf->SetFont('dejavusans', 'B', 11);
            // Mettre en gras pour le téléphone seulement
            $pdf->Write(5, 'Téléphone: ', '', 0, 'L', false, 0, false, false, 0);
            $pdf->SetFont('dejavusans', '', 11); // Remettre le style normal pour le reste du texte
            $pdf->Write(5, '03.52.52.98.66', '', 0, 'L', true, 0, false, false, 0);

            $pdf->SetFont('dejavusans', 'B', 11);
            // Mettre en gras pour le Adresse seulement
            $pdf->Write(5, 'Adresse Postal: ', '', 0, 'L', false, 0, false, false, 0);
            $pdf->SetFont('dejavusans', '', 11); // Remettre le style normal pour le reste du texte
            $pdf->Write(5, '8 rue Pierre Curie', '', 0, 'L', true, 0, false, false, 0);
            $pdf->Write(5, '08000 Charleville-Mézières', '', 0, 'L', true, 0, false, false, 0);


            // Définir la couleur de remplissage pour le titre "Devis Plomberie Securité +"
            $pdf->SetFillColor(255, 193, 7); // Jaune-orange vif (RVB : 255, 193, 7)
            $pdf->SetFont('dejavusans', 'B', 18);
            $pdf->SetXY(90, 0); // Position de la nouvelle ligne de texte (X, Y)
            $pdf->Cell(0, 10, 'DEVIS', 0, 1, 'L'); // Le texte à écrire

            $pdf->SetFont('dejavusans', 'B', 14); // Remettre le style normal pour le reste du texte
            $pdf->SetFillColor(255, 193, 7); // Définir la couleur de remplissage
            $pdf->SetXY(10, 80); // Position de la nouvelle ligne de texte (X, Y)
            $pdf->Cell(0, 10, 'Vos données personnelles', 0, 1, 'L', true); // Le texte à écrire
            $pdf->Ln(3); // Ajouter une marge de 10 unités en dessous du texte de la description des travaux

            $pdf->SetFont('dejavusans', 'B', 11);
            // Mettre en gras pour le nom seulement
            $pdf->Write(5, 'Nom: ', '', 0, 'L', false, 0, false, false, 0);
            $pdf->SetFont('dejavusans', '', 11); // Remettre le style normal pour le reste du texte
            $pdf->Write(5, $devis->getNom(), '', 0, 'L', true, 0, false, false, 0);

            
            $pdf->SetFont('dejavusans', 'B', 11);
            // Mettre en gras pour le nom seulement
            $pdf->Write(5, 'Prénom: ', '', 0, 'L', false, 0, false, false, 0);
            $pdf->SetFont('dejavusans', '', 11); // Remettre le style normal pour le reste du texte
            $pdf->Write(5, $devis->getPrenom(), '', 0, 'L', true, 0, false, false, 0);

            $pdf->SetFont('dejavusans', 'B', 11);
            // Mettre en gras pour l'e-mail seulement
            $pdf->Write(5, 'Email: ', '', 0, 'L', false, 0, false, false, 0);
            $pdf->SetFont('dejavusans', '', 11); // Remettre le style normal pour le reste du texte
            $pdf->Write(5, $devis->getEmail(), '', 0, 'L', true, 0, false, false, 0);

            $pdf->SetFont('dejavusans', 'B', 11);
            // Mettre en gras pour le téléphone seulement
            $pdf->Write(5, 'Téléphone: ', '', 0, 'L', false, 0, false, false, 0);
            $pdf->SetFont('dejavusans', '', 11); // Remettre le style normal pour le reste du texte
            $pdf->Write(5, $devis->getTelephone(), '', 0, 'L', true, 0, false, false, 0);

            $pdf->SetFont('dejavusans', 'B', 11);
            // Mettre en gras pour la description des travaux seulement
            $pdf->Write(5, 'Description des travaux: ', '', 0, 'L', false, 0, false, false, 0);
            $pdf->SetFont('dejavusans', '', 11); // Remettre le style normal pour le reste du texte
            $pdf->Write(5, $devis->getDescriptionTravaux(), '', 0, 'L', true, 0, false, false, 0);
            $pdf->Ln(12); // Ajouter une marge de 10 unités en dessous du texte de la description des travaux

            $pdf->SetFont('dejavusans', 'B', 11);
            // Mettre en gras pour la description des travaux seulement
            $pdf->Write(5, 'Facture: ', '', 0, 'L', false, 0, false, false, 0);
            $pdf->SetFont('dejavusans', '', 11); // Remettre le style normal pour le reste du texte
            $pdf->Write(5, 'Article Commander', '', 0, 'L', true, 0, false, false, 0);
            $pdf->Ln(3); // Ajouter une marge de 10 unités en dessous du texte de la description des travaux

            $header = ['nom', 'Qté', 'P.U.', 'Total'];

            // Afficher le tableau des produits
            $pdf->SetFillColor(255, 193, 7);
            $pdf->SetTextColor(255);
            $pdf->SetDrawColor(128, 0, 0);
            $pdf->SetLineWidth(0.3);
            $pdf->SetFont('', 'B');
            // Header
            $w = array(100, 20, 30, 40);
            $num_headers = count($header);
            for ($i = 0; $i < $num_headers; ++$i) {
                $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
            }
            $pdf->Ln();
            // Color and font restoration
            $pdf->SetFillColor(224, 235, 255);
            $pdf->SetTextColor(0);
            $pdf->SetFont('');
            // Data
            $fill = 0;

            $totalHT = 0;

            foreach ($panierInfo as $row) {
                $totalHT += $row['quantite'] * $row['prix_unitaire'];

                $pdf->Cell($w[0], 10, $row['nom'], 'LR', 0, 'L', $fill);
                $pdf->Cell($w[1], 10, $row['quantite'], 'LR', 0, 'R', $fill);
                $pdf->Cell($w[2], 10, number_format($row['prix_unitaire'], 2, ',', ' '), 'LR', 0, 'R', $fill);
                $pdf->Cell($w[3], 10, number_format($row['quantite'] * $row['prix_unitaire'], 2, ',', ' '), 'LR', 0, 'R', $fill);
                $pdf->Ln();
                $fill = !$fill;
            }

            // Calculer la TVA (20%)
            $tva = $totalHT * 0.2;
            // Calculer le montant total TTC (Toutes Taxes Comprises)
            $totalTTC = $totalHT + $tva;

            // Bas du devis
            // Afficher le total sous le tableau
            $pdf->SetTextColor(0); // Remettre la couleur du texte en noir
            $pdf->SetFont('', 'B', 12); // Modifier la taille de police pour le total
            $pdf->Cell($w[0] + $w[1] + $w[2], 10, 'Total H.T.', 1, 0, 'R');
            $pdf->Cell($w[3], 10, number_format($totalHT, 2, ',', ' '), 1, 1, 'R');
            $pdf->Cell($w[0] + $w[1] + $w[2], 10, 'T.V.A. (20%)', 1, 0, 'R');
            $pdf->Cell($w[3], 10, number_format($tva, 2, ',', '0'), 1, 1, 'R');
            $pdf->Cell($w[0] + $w[1] + $w[2], 10, 'Total T.T.C.', 1, 0, 'R');
            $pdf->Cell($w[3], 10, number_format($totalTTC, 2, ',', ' '), 1, 1, 'R');
            $pdf->Ln();

            $pdf->SetFont('dejavusans', '', 11);
            $pdf->Write(5, 'Nous restons à votre diposition pour toute information complémentaire.', '', 0, 'L', false, 0, false, false, 0);
            $pdf->Ln(5); // Ajouter une marge de 10 unités en dessous du texte de la description des travaux

            $pdf->SetFont('dejavusans', '', 11);
            $pdf->Write(5, 'Cordialement', '', 0, 'L', true, 0, false, false, 0);
            $pdf->Ln(6); // Ajouter une marge de 10 unités en dessous du texte de la description des travaux

            $pdf->SetFont('dejavusans', '', 11);
            $pdf->Write(5, 'Si ce devis vous convient, veuillez nous le retourner signé précédé de la mention :', '', 0, 'L', true, 0, false, false, 0);


            $pdf->SetFont('dejavusans', '', 11);
            $pdf->Write(5, '"BON POUR ACCORD ET EXECUTION DU DEVIS" la durée de validité du devis et de 1 mois.', '', 0, 'L', true, 0, false, false, 0);
            $pdf->Ln(3); // Ajouter une marge de 10 unités en dessous du texte de la description des travaux

            // Ajouter la date du jour après "Nos coordonnees"
            $pdf->SetFont('dejavusans', 'B', 11); // Utiliser une police normale pour la date
            $pdf->SetXY(10, 250); // Position pour afficher la date (ajustez selon vos besoins)
            $pdf->Cell(0, 10, 'Date : ', 0, 1, 'L'); // Afficher la date du jour

            $pdf->SetFont('dejavusans', '', 11); // Remettre le style normal pour le reste du texte
            $pdf->SetXY(40, 250); // Position pour afficher la date (ajustez selon vos besoins)
            $pdf->Cell(0, 10, $dateDuJour, 0, 1, 'L'); // Afficher la date du jour

            // Ajouter la date du jour après "Nos coordonnees"
            $pdf->SetFont('dejavusans', 'B', 11); // Utiliser une police normale pour la date
            $pdf->SetXY(120, 250); // Position pour afficher la date (ajustez selon vos besoins)
            $pdf->Cell(0, 10, 'Signature : ', 0, 1, 'L'); // Afficher la date du jour

            $pdf->SetFont('dejavusans', '', 8);
            $pdf->SetXY(80, 262); // Position pour afficher la date (ajustez selon vos besoins)
            $pdf->Write(5, 'FR 40 123456824 ', '', 0, 'L', true, 0, false, false, 0);
            $pdf->Ln(2); // Ajouter une marge de 10 unités en dessous du texte de la description des travaux
            
            $pdf->SetFont('dejavusans', '', 8);
            $pdf->SetXY(60, 265); // Position pour afficher la date (ajustez selon vos besoins)
            $pdf->Write(5, 'code clé (40) + numéro SIREN (123456824)]', '', 0, 'L', true, 0, false, false, 0);
              

            return($pdf->Output('', 'S'));

    }
}
