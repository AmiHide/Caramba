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

            $ok = Contact::envoyerMail($nom, $email, $message);

            echo $ok ? "SUCCESS" : "ERROR";
            exit;
        }
    }
}
