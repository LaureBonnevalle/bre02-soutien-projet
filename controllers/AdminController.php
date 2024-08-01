<?php

class AdminController extends AbstractController
{
    public function __construct(){
        parent::__construct();
    }

    public function home() : void {
        $this->render('admin/home.html.twig', []);
    }

    public function login() : void {
        $this->render('admin/login.html.twig', []);
    }

    public function checkLogin() : void {
        {

        if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["csrf_token"]))
        {
            $tokenManager = new CSRFTokenManager();

            if(isset($_POST["csrf_token"]) && $tokenManager->validateCSRFToken($_POST["csrf_token"]))
            {
                $um = new UserManager();
                $user = $um->findUserByEmail($_POST["email"]);

                if($user !== null)
                    {
                        if (password_verify($_POST['password'], $user->getPassword()))
                        { 
                            
                            $_SESSION["user"] = $user->getId();
                            $_SESSION["user"] = $user->getRole();
                            
                            unset($_SESSION["error_message"]);
                            
                            $_SESSION['error_message']="vous êtes connecté" ;
                            $this->redirect("admin-list-user");
                        }
                        else
                        {
                            $_SESSION['error_message']="mot de passe incorrect" ;
                            $this->redirect("connexion");
                        }
                    }
                    else
                    {
                        header("Location: index.php?route=login");
                        $_SESSION['error_message']="le compte n'existe pas";  
                    }
            }
            else
            {
                $_SESSION['error_message']="Token non valide";
                $this->redirect("connexion");
            }
        }
        else
        {
            $_SESSION['error_message']="Vous n'avez pas rempli tous les champs";
            $this->redirect("connexion");
        }
        
        
    }
    }
}