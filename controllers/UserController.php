<?php

class UserController extends AbstractController
{
    public function __construct(){
        parent::__construct();
    }

    public function create() : void 
    {
        $this->render("admin/users/create.html.twig", []);
    }

    public function checkCreate() : void 
    {
        if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"]) && isset($_POST['role']))
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
                            $role = htmlspecialchars($_POST["role"]);
                            $user = new User($email, $password, $role);
                            $um->createUser($user); 
                            $_SESSION["id"] = $user->getId();
                            $_SESSION['role'] = $user->getRole();
                            
                            unset($_SESSION["error_message"]);
                            $_SESSION["error_message"] = "Utilisateur créé.";
                            $this->redirect("admin-list-user");
                        }
                        else
                        {
                            $_SESSION["error_message"] = "Un compte existe déjà avec ce mail";
                            $this->redirect("admin-create-user");
                        }
                    }
                    else {
                        $_SESSION["error_message"] = "Le mot de passe n'est pas assez fort.";
                        $this->redirect("admin-create-user");
                    }
                }
                else
                {
                    $_SESSION["error_message"] = "Les mots de passe ne correspondent pas.";
                    $this->redirect("admin-create-user");
                }
            }
            else
            {
                $_SESSION["error_message"] = "Token non valide.";
                $this->redirect("admin-create-user");
            }
        }
        else
        {
            $_SESSION["error_message"] = "Tous les champs ne sont pas remplis.";
            $this->redirect("admin-create-user");
        }
    } 

    public function edit() : void 
    {
        $this->render("admin/users/edit.html.twig", []);
    }

    public function checkEdit() : void 
    {

    }

    public function delete() : void 
    {

    }

    public function list() : void 
    {
        $um = new UserManager();
        
        $userlist= $this->um->findAll();
        
        $this->render("admin/users/list.html.twig", [$userlist]);
    }

    public function show(int $id) : void {
    $this->render("admin/users/show.html.twig", []);
}
    
    
}