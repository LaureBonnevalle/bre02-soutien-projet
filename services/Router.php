<?php


class Router {
    
    public $dc;
    public $ac;
    public $uc;
    public $adc;
    
    public function __construct()
    {
       $this->dc = new DefaultController();
       $this->ac = new AuthController();
       $this->uc = new UserController();
       $this->adc = new AdminController();
    }

    public function handleRequest(? string $route) : void 
    {
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
            
            $this->ac->checkLogin();
        }
        //pour estreindre l'acces des routes aux utilisateurs connectés
        /*else if ($route === 'page-perso' && isset($get['user_id']))
        {
          if(isset($_SESSION['user']) && $_SESSION['user']->getId() === intval($get['user_id'])) 
          {
            echo "je dois afficher la page perso";
            $this->dc->homepageUser();
          }
          else
          {
            // c'est pas bon : redirection avec un header('Location:')
            header("Location: index.php?route=inscription");
            $_SESSION['error_message']="vous n'avez pas les droits d'accés" ; 
          }
        }*/
        else if ($route === 'deconnexion')
        {
            echo "je dois afficher la page home";
            $this->ac->logout();
        }
        else if ($route === 'home')
        {
            echo "je dois afficher la page perso du user";
            $this->dc->home();
        }
        else if ($route = "admin")
        {
            $this->checkAdminAccess();
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
        else if($route === "admin-create-user")
        {
            $this->checkAdminAccess();
            $this->uc->create();
        }
        else if($route === "admin-check-create-user")
        {
            $this->checkAdminAccess();
            $this->uc->checkCreate();
        }
        else if($route === "admin-edit-user")
        {
            $this->checkAdminAccess();
            
            if (isset($_GET['user_id'])) {
                $userId = (int)$_GET['user_id'];
                $this->uc->edit($userId);
            } else {
                $this->redirect("admin-list-user");
            }
        }
        else if($route === "admin-check-edit-user")
        {
            $this->checkAdminAccess();
            $this->uc->checkEdit();
        }
        else if($route === "admin-delete-user")
        {
            $this->checkAdminAccess();
            $this->uc->delete();
        }
        else if($route === "admin-list-user")
        {
            $this->checkAdminAccess();
            $this->uc->list();
        }
        else if($route === "admin-show-user")
        {
            $this->checkAdminAccess();
            //vérifie si le paramètre $_GET['user_id'] existe.
            if(isset($_GET['user_id']))
            {

                $userId = (int)$_GET['user_id'];
               
                $this->uc->show($userId);
            }
            else
            {
                $this->redirect("admin-list-user");
            }
        }
        else
        {
            // le code si c'est aucun des cas précédents ( === page 404)
            echo "je dois afficher la page 404";
            $this->dc->notFound();
            
        }
    }
     function checkAdminAccess(): void
        {
            if(isset($_SESSION['user_id']) && isset($_SESSION['user_role']) && $_SESSION["user_role"] === "ADMIN")
            {
                
            }
            else
            {
                     // c'est pas bon : redirection avec un header('Location:')
                     $_SESSION['error_message']="vous n'avez pas les droits d'accès";
                     header("Location: index.php?route=connexion");
            }
        }   
}

