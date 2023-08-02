<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Panier;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route("/cart", name="cart_")
 */
class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, ArticleRepository $articleRepository): Response 
    {
        $panier = $session->get("panier", []);

        //on fabrique les données
        $dataPanier = [];
        $total = 0;

        foreach($panier as $id => $quantite){
            $article = $articleRepository->find($id);
            $dataPanier[] = [
                "produit" => $article,
                "quantite" => $quantite
            ];
            $total += $article->getPrix() * $quantite;
        }
                    //utiliser compact pour eviter de retaper tout
        return $this->render('cart/index.html.twig', compact("dataPanier",
         "total"));
    }

    /**
     * @Route("/add/{id}", name="add")
     * @return void
     */
    public function add(Article $article, SessionInterface $session)
    {
        //on récupère le panier actuel
        //mon panier vaudra als soit panier ou soit un tableau vide
        $panier = $session->get("panier", []);
        $id = $article->getId();
      

        if(empty($panier[$id])){
            $panier[$id] = 0;
        }
        $panier[$id]++;   
        
        //on sauvgarde ds la session
        $session->set("panier", $panier,'panier', $panier, );

        return $this->redirectToRoute("cart_index");
       
    }

     /**
     * @Route("/remove/{id}", name="remove")
     * @return void
     */
    public function remove(Article $article, SessionInterface $session)
    {
        //on récupère le panier actuel
        //mon panier vaudra als soit panier ou soit un tableau vide
        $panier = $session->get("panier", []);
        $id = $article->getId();
      
        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                 $panier[$id]--;  
            }else{
                unset($panier[$id]);
            }
        }
        
        //on sauvgarde ds la session
        $session->set("panier", $panier,'panier', $panier, );

        return $this->redirectToRoute("cart_index");
       
      
       
    }

     /**
     * @Route("/delete/{id}", name="delete")
     * @return void
     */
    public function delete(Article $article, SessionInterface $session)
    {
        //on récupère le panier actuel
        //mon panier vaudra als soit panier ou soit un tableau vide
        $panier = $session->get("panier", []);
        $id = $article->getId();
      
        if(!empty($panier[$id])){
                unset($panier[$id]);
            
        }
        
        //on sauvgarde ds la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
       
      
       
    }

     /**
     * @Route("/delete", name="delete_all")
     * @return void
     */
    public function deleteall(SessionInterface $session)
    {
       

        $session->set("panier", []);

        return $this->redirectToRoute("cart_index");
       
      
       
    }
}



    // $session->set("panier", 3);

    // dd($session->get("panier"));