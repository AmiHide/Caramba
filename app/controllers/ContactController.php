<?php

class ContactController {

    public function form() {
        require __DIR__ . '/../views/contact.php';
    }

    public function send() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $nom     = $_POST["nom"] ?? "";
            $email   = $_POST["email"] ?? "";
            $message = $_POST["message"] ?? "";

            $result = Contact::envoyerMail($nom, $email, $message);

            // Si le retour est strictement true -> SUCCESS, sinon on affiche l'erreur
            if ($result === true) {
                echo "SUCCESS";
            } else {
                // Affiche l'erreur renvoyée par le modèle (ex: Password incorrect)
                echo $result; 
            }
            exit;
        }
    }
}
