
import { slugify } from 'slugify';

const articleIdElement = document.getElementById('article-id');
const articleId = articleIdElement.value;
const articleSlug = slugify(articleId, { lower: true, strict: true });

const url = `/article/${articleSlug}-${articleId}`;
articleIdElement.value = url; // Mettez à jour la valeur de l'élément avec l'URL complète

// Vous pouvez également afficher l'URL dans la console pour le débogage
console.log(url);
