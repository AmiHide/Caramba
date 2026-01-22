<?php

class VerifyEmailController
{
    public function index()
    {
        $token = $_GET['token'] ?? null;

        if (!$token) {
            $_SESSION['flash_error'] = "Lien invalide.";
            header("Location: index.php?page=connexion");
            exit;
        }

        require_once __DIR__ . '/../models/User.php';
        
        if (User::verifyAccount($token)) {
            $_SESSION['login_success'] = "Votre email a été vérifié avec succès ! Vous pouvez maintenant vous connecter.";
        } else {
            $_SESSION['flash_error'] = "Ce lien est invalide ou a déjà été utilisé.";
        }

        header("Location: index.php?page=connexion");
        exit;
    }
}