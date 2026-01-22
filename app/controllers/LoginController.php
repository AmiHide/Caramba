<?php

class LoginController
{
    public function index()
    {
        $message = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $email = trim($_POST["email"]);
            $password = trim($_POST["password"]);

            if (!empty($email) && !empty($password)) {

                $user = User::getByEmail($email);

                if ($user && password_verify($password, $user["mot_de_passe"])) {

                    $_SESSION["user"] = [
                        "id" => $user["id"],
                        "nom" => $user["nom"],
                        "email" => $user["email"],
                        "avatar" => $user["avatar"] ?? "user-icon.png",
                        "role" => $user["role"],
                        "conducteur_demande" => $user["conducteur_demande"],
                        "conducteur_valide" => $user["conducteur_valide"],
                        "pseudo" => $user["pseudo"]
                    ];
                    $_SESSION['user']['super_driver'] = User::isSuperDriver($_SESSION['user']['id']);

                    $_SESSION["login_success"] =
                        "Connexion réussie 👌 Bienvenue " . $user['nom'] . " !";

                    header("Location: index.php?page=home");
                    exit;
                } else {
                    $message = "L'adresse e-mail ou le mot de passe est incorrect.";
                }
            } else {
                $message = "Veuillez remplir tous les champs.";
            }
        }

        require __DIR__ . '/../views/connexion.php';
    }
}
