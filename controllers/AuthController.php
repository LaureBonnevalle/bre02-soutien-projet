<?php

class AuthController extends AbstractController {

    private UserManager $um;
    
    public function __construct() {
        parent::__construct();
        $this->um = new UserManager();
    }
    
    public function register() : void
    {
        $this->render('front/register.html.twig', []);
    }
    
    public function checkRegister() : void
    {
        if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"]))
        {
            $tokenManager = new CSRFTokenManager();
            if(isset($_POST["csrf_token"]) && $tokenManager->validateCSRFToken($_POST["csrf_token"]))
            {
                if($_POST["password"] === $_POST["confirm_password"])
                {
                    $password_pattern = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";

                    if (preg_match($password_pattern, $_POST["password"]))
                    {
                        $um = new UserManager();
                        $user = $um->findUserByEmail($_POST["email"]);

                        if($user === null)
                        {
                            $email = htmlspecialchars($_POST["email"]);
                            $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
                            $user = new User($email, $password, 'USER');
                            $um->createUser($user); 
                            $_SESSION["user"] = $user->getId();
                            unset($_SESSION["error_message"]);
                            $_SESSION["error_message"] = "Vous êtes inscrit. Vous pouvez vous connecter.";
                            $this->redirect("connexion");
                        }
                        else
                        {
                            $_SESSION["error_message"] = "Un compte existe déjà. Vous pouvez vous connecter.";
                            $this->redirect("inscription");
                        }
                    }
                    else {
                        $_SESSION["error_message"] = "Le mot de passe n'est pas assez fort.";
                        $this->redirect("inscription");
                    }
                }
                else
                {
                    $_SESSION["error_message"] = "Les mots de passe ne correspondent pas.";
                    $this->redirect("inscription");
                }
            }
            else
            {
                $_SESSION["error_message"] = "Token non valide.";
                $this->redirect("inscription");
            }
        }
        else
        {
            $_SESSION["error_message"] = "Tous les champs ne sont pas remplis.";
            $this->redirect("inscription");
        }
    } 
    
    public function login() : void
    {
        $this->render('front/login.html.twig', []);
    }
    
    public function checkLogin() : void 
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
                            header("Location: index.php");
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
    
    public function logout() : void
    {
        session_destroy();
        $message="Vous êtes déconnecté.";
        header("Location: index.php");
                    
    }
}