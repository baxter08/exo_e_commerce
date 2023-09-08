<?php

namespace App\Util;

use Symfony\Component\String\Slugger\SluggerInterface;

class SlugifyUtil
{
    public function __construct(private SluggerInterface $slugger) {
    }

    public function slugify(string $text) : string
    {
        
        // Implémentez ici la logique de génération du slug à partir du texte
        // Vous pouvez utiliser des fonctions comme strtolower(), preg_replace(), etc.
        // pour formater le texte et supprimer les caractères indésirables
        // afin d'obtenir un slug valide.
        // Voici un exemple simple qui remplace les espaces par des tirets :


        return $this->slugger->slug(substr(trim($text), 0, 30)) . '-' . uniqid();
    }
}
