<?php

class UserController extends AbstractController
{
    public function __construct(){
        parent::__construct();
    }

    public function create() : void {
        $this->render("admin/users/create.html.twig", []);
    }

    public function checkCreate() : void {

    }

    public function edit() : void {
        $this->render("admin/users/edit.html.twig", []);
    }

    public function checkEdit() : void {

    }

    public function delete() : void {

    }

    public function list() : void {
        $um = new UserManager();
        
        $userlist= $this->um->findAll();
        
        $this->render("admin/users/list.html.twig", [$userlist]);
    }

    public function show() : void {
        $this->render("admin/users/show.html.twig", []);
    }
    
    public function findAllUsers(): array
    {
        
    }
}
