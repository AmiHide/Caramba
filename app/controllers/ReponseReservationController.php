<?php

class ReponseReservationController
{
    public function index()
    {

        if (!isset($_SESSION["user"]["id"])) {
            header("Location: index.php?page=connexion");
            exit;
        }

        $userId = $_SESSION["user"]["id"];


        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: index.php?page=mestrajets");
            exit;
        }

        $action   = $_POST["action"] ?? null;          
        $resId    = intval($_POST["reservation_id"] ?? 0);
        $trajetId = intval($_POST["trajet_id"] ?? 0);

        if (!$action || !$resId || !$trajetId) {
            $_SESSION["flash_error"] = "Requête invalide.";
            header("Location: index.php?page=mestrajets");
            exit;
        }

        global $pdo;


        // --- CORRECTION ICI ---
        // On récupère simplement 'places_disponibles' car cette colonne
        // est déjà mise à jour lors de l'acceptation précédente.
        $stmt = $pdo->prepare("
            SELECT t.*, t.places_disponibles AS places_restantes
            FROM trajets t
            WHERE t.id = ?
              AND t.conducteur_id = ?
        ");
        // ----------------------

        $stmt->execute([$trajetId, $userId]);
        $trajet = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$trajet) {
            $_SESSION["flash_error"] = "Action non autorisée.";
            header("Location: index.php?page=mestrajets");
            exit;
        }


        $stmt = $pdo->prepare("SELECT * FROM reservations WHERE id = ?");
        $stmt->execute([$resId]);
        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reservation) {
            $_SESSION["flash_error"] = "Réservation introuvable.";
            header("Location: index.php?page=mestrajets");
            exit;
        }


        if ($reservation["expire_at"] < date("Y-m-d H:i:s")) {
            Reservation::marquerExpirees();
            $_SESSION["flash_error"] = "La demande a expiré.";
            header("Location: index.php?page=mestrajets");
            exit;
        }


        if ($action === "accepter") {

            $ok = Reservation::accepter($resId, $trajetId, $trajet["places_restantes"]);
            
            require_once __DIR__ . '/../models/Notification.php';

            Notification::add(
                $reservation['passager_id'],
                "Votre réservation pour {$trajet['depart']} → {$trajet['arrivee']} a été acceptée."
            );
            
            if ($ok) {
                $_SESSION["flash_success"] = "Réservation acceptée";
            } else {
                $_SESSION["flash_error"] = "Impossible d'accepter cette demande (plus de place).";
            }

        } elseif ($action === "refuser") {

            $ok = Reservation::refuser($resId);
            require_once __DIR__ . '/../models/Notification.php';

            Notification::add(
                $reservation['passager_id'],
                "Votre réservation pour {$trajet['depart']} → {$trajet['arrivee']} a été refusée."
            );

            $_SESSION["flash_success"] = $ok
                ? "Réservation refusée ❌"
                : "Erreur lors du refus.";
        }

        header("Location: index.php?page=mestrajets");
        exit;
    }
}
