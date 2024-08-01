<?php


class Router {
    
    public $dc;
    public $ac;
    
    public function __construct()
    {
       $this->dc = new DefaultController();
       $this->ac = new AuthController();
    }

    public function handleRequest(? string $route) : void {
        if($route === null)
        {
            // le code si il n'y a pas de route ( === la page d'accueil)
            echo "je dois afficher la page d'accueil";
            $this->dc->homepage();
        }
        /*else if ($route= "accueil")
        {
            echo "je dois afficher la page d'accueil";
            $this->dc->homepage();
        }*/
        else if ($route === 'inscription')
        {
            echo "je dois afficher la page d'inscription";
            $this->ac->register();
        }
        else if ($route === 'check-inscription')
        {
            $this->ac->checkRegister();
        }
        else if ($route === 'connexion')
        {
            echo "je dois afficher la page de connexion";
            $this->ac->login();
        }
        else if ($route === 'check-connexion')
        {
            echo "je dois afficher la page d'inscription";
            $this->ac->checkLogin();
        }
        else if ($route === 'deconnexion')
        {
            echo "je dois afficher la page de connexion";
            $this->ac->logout();
        }
        else if ($route === 'homepage_user')
        {
            echo "je dois afficher la page perso du user";
            $this->dc->homepageUser();
        }
        else
        {
            // le code si c'est aucun des cas précédents ( === page 404)
            echo "je dois afficher la page 404";
            $this->dc->notFound();
            
        }
    }
}
