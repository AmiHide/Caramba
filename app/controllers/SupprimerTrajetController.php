<?php

class SupprimerTrajetController
{
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=connexion");
            exit;
        }

        // Vérifier si l'ID du trajet est passé
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            $_SESSION['flash_error'] = "Aucun trajet spécifié.";
            header("Location: index.php?page=mestrajets");
            exit;
        }

        $id = (int) $_GET['id'];

        require_once __DIR__ . '/../models/Trajet.php';

        $deleted = Trajet::deleteTrajet($id);

        if ($deleted) {
            $_SESSION['flash_success'] = "Le trajet a bien été supprimé.";
        } else {
            $_SESSION['flash_error'] = "Une erreur est survenue lors de la suppression du trajet.";
        }

        header("Location: index.php?page=mestrajets");
        exit;
    }
}
