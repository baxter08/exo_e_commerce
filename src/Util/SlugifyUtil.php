<?php

namespace App\Util;

class SlugifyUtil
{
    public static function slugify($text)
    {
        // Implémentez ici la logique de génération du slug à partir du texte
        // Vous pouvez utiliser des fonctions comme strtolower(), preg_replace(), etc.
        // pour formater le texte et supprimer les caractères indésirables
        // afin d'obtenir un slug valide.
        // Voici un exemple simple qui remplace les espaces par des tirets :
        return str_replace(' ', '-', $text);
    }
}
