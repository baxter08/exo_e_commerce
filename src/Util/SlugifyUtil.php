<?php

namespace App\Util;

use Symfony\Component\String\Slugger\SluggerInterface;

class SlugifyUtil
{
    public function __construct(private SluggerInterface $slugger) {
    }

    public function slugify(string $text) : string
    {


        return $this->slugger->slug(substr(trim($text), 0, 30)) . '-' . uniqid();
    }
}
