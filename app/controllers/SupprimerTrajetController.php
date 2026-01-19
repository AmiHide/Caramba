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
        $userId = $_SESSION['user']['id'];

        // Vérifions que le trajet appartient bien au conducteur connecté
        $trajet = Trajet::getByIdWithConducteur($id);

        if (!$trajet || $trajet['conducteur_id'] != $userId) {
            $_SESSION['flash_error'] = "Vous n'avez pas le droit de supprimer ce trajet.";
            header("Location: index.php?page=mestrajets");
            exit;
        }

        // Vérifions si le trajet est déjà passé
        $dateDepart = new DateTime($trajet['date_depart'] . ' ' . $trajet['heure_depart']);
        $now = new DateTime();

        if ($dateDepart < $now) {
            $_SESSION['flash_error'] = "Impossible de supprimer un trajet déjà passé.";
            header("Location: index.php?page=mestrajets");
            exit;
        }

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
