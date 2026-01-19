<?php

require_once __DIR__ . '/../models/Mailer.php';

class ForgotController {

    public function index() {

        $message = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $email = trim($_POST["email"]);
            $user = User::findByEmail($email);

            if ($user) {

                $token = bin2hex(random_bytes(32));
                $expire = date("Y-m-d H:i:s", time() + 3600);

                User::setResetToken($email, $token, $expire);

                // Appel statique (::) qui correspond maintenant à votre Mailer
                if (Mailer::sendPasswordReset($email, $token)) {
                    $message = "Un email de réinitialisation a été envoyé à l'adresse indiquée.";
                } else {
                    $message = "Une erreur technique est survenue lors de l'envoi de l'email.";
                }

            } else {
                $message = "Si cette adresse correspond à un compte, un email a été envoyé.";
            }
        }

        require __DIR__ . '/../views/forgot.php';
    }
}
