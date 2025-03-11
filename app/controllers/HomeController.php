<?php

require_once "../core/Controller.php";

class HomeController extends Controller{

    public function index() {
        
        $this->checkAuth();

        $username = $_SESSION['username'];

        $content = $this->loadView('home', compact('username'));
        require_once "../app/views/layout/layout.php";
    }

}
