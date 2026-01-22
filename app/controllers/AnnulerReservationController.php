<?php

class AnnulerReservationController
{
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=connexion");
            exit;
        }

        if (!isset($_POST['id'])) {
            $_SESSION['flash_error'] = "Aucune réservation spécifiée.";
            header("Location: index.php?page=mestrajets");
            exit;
        }

        $resId = (int) $_POST['id'];
        $userId = $_SESSION['user']['id'];

        // Récupérer les infos de la réservation et du trajet
        require_once __DIR__ . '/../models/Reservation.php';
        require_once __DIR__ . '/../models/Trajet.php';

        $reservation = Reservation::getById($resId);
        
        if (!$reservation || $reservation['passager_id'] != $userId) {
            $_SESSION['flash_error'] = "Action non autorisée.";
            header("Location: index.php?page=mestrajets");
            exit;
        }

        // Vérification de la deadline
        $trajet = Trajet::getByIdWithConducteur($reservation['trajet_id']);
        $dateDepart = new DateTime($trajet['date_depart'] . ' ' . $trajet['heure_depart']);
        $now = new DateTime();
        
        // Calcul du délai (Exemple : 24h avant)
        $interval = $now->diff($dateDepart);
        // Si la date est passée ou si le délai est inférieur à 24h (1 jour)
        $isTooLate = ($dateDepart < $now) || ($interval->days < 1 && $interval->invert == 0);

        if ($isTooLate) {
            $_SESSION['flash_error'] = "Impossible d'annuler : le départ est dans moins de 24h.";
            header("Location: index.php?page=mestrajets");
            exit;
        }

        if (Reservation::annuler($resId)) {
            $_SESSION['flash_success'] = "Votre réservation a été annulée et les places libérées.";
        } else {
            $_SESSION['flash_error'] = "Une erreur est survenue lors de l'annulation.";
        }

        header("Location: index.php?page=mestrajets");
        exit;
    }
}