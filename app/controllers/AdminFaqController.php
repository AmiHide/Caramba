<?php

class AdminFaqController
{
    public function index()
    {
        if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
            header("Location: index.php");
            exit;
        }

        // Ajout d'une question
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $question = trim($_POST["question"] ?? "");
            $reponse  = trim($_POST["reponse"] ?? "");

            if ($question !== "" && $reponse !== "") {
                Faq::create($question, $reponse);
                $_SESSION["flash_success"] = "Question ajoutée avec succès.";
            } else {
                $_SESSION["flash_error"] = "Les deux champs sont obligatoires.";
            }

            header("Location: index.php?page=admin_faq");
            exit;
        }

        // Delete une question
        if (isset($_GET["delete"])) {
            Faq::delete((int) $_GET["delete"]);
            $_SESSION["flash_success"] = "Question supprimée.";
            header("Location: index.php?page=admin_faq");
            exit;
        }

        // Récup de ttes les questions
        $faq = Faq::getAllDesc();

        require __DIR__ . '/../views/admin/faq.php';
    }
}