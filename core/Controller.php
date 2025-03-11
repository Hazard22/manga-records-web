<?php

class Controller {

    protected function checkAuth() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); 
        }

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /manga-management");
            exit;
        }
    }

    protected function loadView($view, $data = []) {
        extract($data); 
        ob_start();
        require_once "../app/views/{$view}.php";
        return ob_get_clean(); 
    }
}
