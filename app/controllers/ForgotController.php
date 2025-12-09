<?php

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

                // lien local (test l'envoi auto par mail nxt step)
                $resetLink = "http://localhost/caramba/public/index.php?page=reset&token=$token";

                $message = "Un lien de réinitialisation a été généré :<br><br>
                            <a href='$resetLink'>$resetLink</a>";

            } else {
                $message = "Cet e-mail n'existe pas.";
            }
        }

        require __DIR__ . '/../views/forgot.php';
    }
}
