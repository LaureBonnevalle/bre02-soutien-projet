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
        else if ($route === 'page-perso' && isset($get['user_id']))
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
        }
        else if ($route = 'admin')
        {
            if(isset($_SESSION['user']) && $_SESSION['user']->getRole() === "ADMIN")
            {
                $this->adc->home();
            }
            else
            {
                header("Location: index.php?route=inscription");
                $_SESSION['error_message']="vous n'avez pas les droits d'accés" ;  
            }
            
        }
        else if ($route = 'admin-connexion')
        {
            if(isset($_SESSION['user']) && $_SESSION['user']->getRole() === "ADMIN")
            {
                this->adc->login();
            }
            else
            {
                header("Location: index.php?route=inscription");
                $_SESSION['error_message']="vous n'avez pas les droits d'accés" ;  
            }
            
        }
        else if ($route = 'admin-check-connexion')
        {
            if(isset($_SESSION['user']) && $_SESSION['user']->getRole() === "ADMIN")
            {
                $this->adc->checkLogin();
            }
            else
            {
                header("Location: index.php?route=inscription");
                $_SESSION['error_message']="vous n'avez pas les droits d'accés" ;  
            }
            
        }
        else if ($route = 'admin-create-user')
        {
            if(isset($_SESSION['user']) && $_SESSION['user']->getRole() === "ADMIN")
            {
                $this->uc->create();
            }
            else
            {
                header("Location: index.php?route=inscription");
                $_SESSION['error_message']="vous n'avez pas les droits d'accés" ;  
            }
            
        }
        else if ($route = 'admin-check-create-user')
        {
            if(isset($_SESSION['user']) && $_SESSION['user']->getRole() === "ADMIN")
            {
                $this->uc->checkCreate();
            else
            {
                header("Location: index.php?route=inscription");
                $_SESSION['error_message']="vous n'avez pas les droits d'accés" ;  
            }
            
        }
        else if ($route = 'admin-edit-user')
        {
            if(isset($_SESSION['user']) && $_SESSION['user']->getRole() === "ADMIN")
            {
                $this->uc->edit();
            }
            else
            {
                header("Location: index.php?route=inscription");
                $_SESSION['error_message']="vous n'avez pas les droits d'accés" ;  
            }
        }
        else if ($route = 'admin-check-edit-user')
        {
            if(isset($_SESSION['user']) && $_SESSION['user']->getRole() === "ADMIN")
            {
                $this->uc->checkEdit();
            }
            else
            {
                header("Location: index.php?route=inscription");
                $_SESSION['error_message']="vous n'avez pas les droits d'accés" ;  
            }
        }
        else if ($route = 'admin-delete-user')
        {
            if(isset($_SESSION['user']) && $_SESSION['user']->getRole() === "ADMIN")
            {
                $this->uc->delete();
            }
            else
            {
                header("Location: index.php?route=inscription");
                $_SESSION['error_message']="vous n'avez pas les droits d'accés" ;  
            }
            
        }
        else if ($route = 'admin-list-user')
        {
            
            if(isset($_SESSION['user']) && $_SESSION['user']->getRole() === "ADMIN")
            {
                $this->uc->list();
            }
            else
            {
                header("Location: index.php?route=inscription");
                $_SESSION['error_message']="vous n'avez pas les droits d'accés" ;  
            }
        }
        else if ($route = 'admin-show-user')
        {
            if(isset($_SESSION['user']) && $_SESSION['user']->getRole() === "ADMIN")
            {
                $this->uc->show();
            }
            else
            {
                header("Location: index.php?route=inscription");
                $_SESSION['error_message']="vous n'avez pas les droits d'accés" ;  
            }
            
        else
        {
            // le code si c'est aucun des cas précédents ( === page 404)
            echo "je dois afficher la page 404";
            $this->dc->notFound();
            
        }
    }
}
