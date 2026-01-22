<?php

class ChangeEmailController
{
    public function index()
    {

        $success = "";
        $error = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $email = trim($_POST["email"]);

            // voir si le mail existe dans notre base
            $user = User::getByEmail($email);

            if ($user) {

                // Si oui on génère un token temporaire
                $token  = bin2hex(random_bytes(32));
                $expire = date("Y-m-d H:i:s", time() + 3600);

                User::storeEmailResetToken($email, $token, $expire);

                // Lien
                $link = "http://localhost/caramba/public/index.php?page=change_email_confirm&token=$token";

                $success = "
                    <p>Un lien de modification d'e-mail a été généré.</p>
                    <p>Ouvrez ce lien :</p>
                    <p><a href='$link'>$link</a></p>
                ";
            } else {
                $error = "Cet e-mail n'existe pas.";
            }
        }

        require __DIR__ . '/../views/change_email.php';
    }
}
