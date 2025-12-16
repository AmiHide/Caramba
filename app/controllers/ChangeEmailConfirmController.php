<?php

class ChangeEmailConfirmController
{
    public function index()
    {
        session_start();

        if (!isset($_GET["token"])) {
            die("Lien invalide.");
        }

        $token = $_GET["token"];
        $user = User::getByResetToken($token);

        if (!$user) {
            die("Lien invalide.");
        }

        if (strtotime($user["reset_expire"]) < time()) {
            die("Lien expiré.");
        }

        $message = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $new1 = trim($_POST["email1"]);
            $new2 = trim($_POST["email2"]);

            if ($new1 !== $new2) {
                $message = "<p style='color:red'>Les e-mails ne correspondent pas.</p>";

            } elseif (!filter_var($new1, FILTER_VALIDATE_EMAIL)) {
                $message = "<p style='color:red'>Adresse e-mail invalide.</p>";

            } elseif (User::emailExistsForOther($new1, $user["id"])) {
                $message = "<p style='color:red'>Cet e-mail est déjà utilisé.</p>";

            } else {
                User::updateEmail($user["id"], $new1);
                $message = "<p style='color:green'>Adresse e-mail mise à jour.</p>";

                header("refresh:2; url=index.php?page=profil&id={$user['id']}");
            }
        }

        require __DIR__ . '/../views/change_email_confirm.php';
    }
}
