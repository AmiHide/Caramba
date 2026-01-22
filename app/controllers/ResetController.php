<?php

class ResetController {

    public function index() {

        if (!isset($_GET["token"])) {
            die("Token invalide");
        }

        $token = $_GET["token"];
        $user = User::findByToken($token);

        if (!$user) {
            die("Lien invalide");
        }

        if (strtotime($user["reset_expire"]) < time()) {
            die("Lien expiré");
        }

        $message = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $pass1 = $_POST["p1"];
            $pass2 = $_POST["p2"];

            if ($pass1 === $pass2 && strlen($pass1) >= 6) {

                $hash = password_hash($pass1, PASSWORD_DEFAULT);

                User::updatePassword($user["id"], $hash);

                $message = "<p style='color:green'>Mot de passe mis à jour !</p>";
                header("refresh:2; url=index.php?page=connexion");
            } 
            else {
                $message = "<p style='color:red'>Les mots de passe ne correspondent pas.</p>";
            }
        }

        require __DIR__ . '/../views/reset.php';
    }
}
