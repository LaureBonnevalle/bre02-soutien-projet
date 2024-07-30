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
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
        $user = new User($_POST['email'], $password, "USER");
    
        $this->um->createUser($user);
        
        if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST['confirm_password']) && isset($_POST['csrf_token']))
        {
            if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"]))
            {
                /*echo"<pre>";
                var_dump($_POST['csrf-token']);
                echo"</pre>";*/
                if ($this->um->finByEmail() === 0) // ??? kézako
                {
                    if ($_POST['password']=== $_POST['confirm_password'])
                    {
                        if (preg_match($password_pattern, $password)===1)
                        {
                             $user = new User(null, $email, $password, $role = "USER");
                             $um->createUser($user);
                             header("Location: index.php?route=login");
                             $_SESSION['message']="vous êtes inscrit";
                        } 
                        else
                        {
                            header("Location: index.php?route=register");
                            $_SESSION[error_message]="le mot de passe n'est pas assez fort" ;
                        }
                    }
                    else
                    {
                        header("Location: index.php?route=register");
                        $_SESSION[error_message]="les mots de passe ne correspondent pas" ; 
                    }
                }
                else
                {
                    header("Location: index.php?route=register");
                    $_SESSION[error_message]="un compte existe déja avec cette adresse mail" ;
                }
                
            }
            else
            {
                header("Location: index.php?route=register");
                $_SESSION[error_message]="erreur token" ; 
            }
        }
        else
        {
            header("Location: index.php?route=register");
            $_SESSION[error_message]="Vous n'avez pas rempli tous les champs"; 
        }
    } 
    
    public function login() : void
    {
        $this->render('front/login.html.twig', []);
    }
    
    public function checkLogin() : void 
    {

        $user = $this->um->findUserByEmail($_POST['email']);
        var_dump($user);
        
        if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST['csrf_token']))
        {
            if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"]))
            {
                /*echo"<pre>";
                var_dump($_POST['csrf-token']);
                echo"</pre>";*/
                $user = $um->findByEmail($_POST['email']);
                        
                        
                    if($user !== null)
                    {
                        if (password_verify($_POST['password'], $user->getPassword()))
                        { 
                            
                            $_SESSION["user"] = $user->getId()->getRole();
                            header("Location: index.php?route=homepage_user");
                            $_SESSION[message]="vous êtes connecté" ;
                        }
                        else
                        {
                            header("Location: index.php?route=login");
                            $_SESSION[error_message]="mot de passe incorrect" ;
                        }
                    }
                    else
                    {
                        header("Location: index.php?route=login");
                        $_SESSION[error_message]="le compte n'existe pas";  
                    }
            }
            else
            {
                header("Location: index.php?route=login");
                $_SESSION[error_message]="Vous n'avez pas rempli tous les champs";
            }
        }
        else
        {
            header("Location: index.php?route=login");
            $_SESSION[error_message]="Vous n'avez pas rempli tous les champs";
        }
        
        
    }
    
    public function logout() : void
    {
        session_destroy();
        header("Location: index.php?route=home");
        $_SESSION[message]="Vous êtes déconnectés";
    }
}