<?php
namespace App\Controller;

use TCPDF;

class PDFGenerator extends TCPDF
{
    public function generateDevis(array $devisData): string
    {
        $this->AddPage();

        // Définir les informations du devis à afficher
        $nom = $devisData['nom'];
        $email = $devisData['email'];
        $telephone = $devisData['telephone'];
        $descriptionTravaux = $devisData['descriptionTravaux'];

        // Ajouter les informations du devis au contenu du PDF
        $this->SetFont('dejavusans', '', 12);
        $this->Write(0, 'Nom: ' . $nom, '', 0, 'L', true, 0, false, false, 0);
        $this->Write(0, 'Email: ' . $email, '', 0, 'L', true, 0, false, false, 0);
        $this->Write(0, 'Téléphone: ' . $telephone, '', 0, 'L', true, 0, false, false, 0);
        $this->Write(0, 'Description des travaux: ' . $descriptionTravaux, '', 0, 'L', true, 0, false, false, 0);

        // Récupérer le contenu du PDF sous forme de chaîne
        return $this->Output('', 'S');
    }
}
