<?php


class Router {
    
    public $dc;
    public $ac;
    
    public function __construct()
    {
       $this->dc = new DefaultController();
       $this->ac = new AuthController();
       $this->uc = new UserController();
       $this->adc = new AdminController();
    }

    public function handleRequest(? string $route) : void {
        if($route === null)
        {
            // le code si il n'y a pas de route ( === la page d'accueil)
            echo "je dois afficher la page d'accueil";
            $this->dc->homepage();
        }
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
            $this->ac->checkLogin();
        }
        else if ($route === 'deconnexion')
        {
            echo "je dois afficher la page d' accueil";
            $this->ac->logOut();
        }
        else if ($route === 'page-perso')
        {
            echo "je dois afficher la page perso";
            $this->dc->home();
        }
        else if ($route = 'admin')
        {
            $this->adc->home();
        }
        else if ($route = 'admin-connexion')
        {
            $this->adc->login();
        }
        else if ($route = 'admin-check-connexion')
        {
            $this->adc->checkLogin();
        }
        else if ($route = 'admin-create-user')
        {
            $this->uc->create();
        }
        else if ($route = 'admin-check-create-user')
        {
            $this->uc->checkCreate();
        }
        else if ($route = 'admin-edit-user')
        {
            $this->uc->edit();
        }
        else if ($route = 'admin-check-edit-user')
        {
            $this->uc->checkEdit();
        }
        else if ($route = 'admin-delete-user')
        {
           $this->uc->delete(); 
        }
        else if ($route = 'admin-list-user')
        {
            $this->uc->list();
        }
        else if ($route = 'admin-show-user')
        {
            $this->uc->show();
        }
        else
        {
            // le code si c'est aucun des cas précédents ( === page 404)
            echo "je dois afficher la page 404";
            $this->dc->notFound();
            
        }
    }
}
