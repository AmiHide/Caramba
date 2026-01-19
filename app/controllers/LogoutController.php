<?php

class LogoutController {

    public function index() {
        session_unset();
        session_destroy();

        // Retour à la page d'accueil du site
        header("Location: index.php?page=home");
        exit;
    }
}