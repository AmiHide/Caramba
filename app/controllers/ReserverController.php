<?php

class ReserverController
{
    public function index()
    {

        if (!isset($_GET['id'])) {
            header("Location: index.php?page=home");
            exit;
        }

        $trajetId = (int) $_GET['id'];

        require_once __DIR__ . '/../models/Trajet.php';
        require_once __DIR__ . '/../models/Reservation.php';
        require_once __DIR__ . '/../models/User.php';

        $trajet = Trajet::getByIdWithConducteur($trajetId);
        if (!$trajet) {
            echo "Trajet introuvable.";
            exit;
        }

        $userId = $_SESSION['user']['id'] ?? ($_SESSION['user_id'] ?? null);
        if (!$userId) {
            header("Location: index.php?page=connexion");
            exit;
        }

        // Ici pour interdire au conducteur de réserver son propre trajet
        if ((int)$trajet['conducteur_id'] === (int)$userId) {
            $_SESSION['error'] = "Vous ne pouvez pas réserver votre propre trajet.";
            header("Location: index.php?page=recherche");
            exit;
        }

        // Traitement POST (confirmation réservation)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!Reservation::existsForUser($userId, $trajetId)) {

                $places = 1; 
                $expireAt = date("Y-m-d H:i:s", time() + 24 * 3600);

                Reservation::createPending($trajetId, $userId, $places, $expireAt);
                require_once __DIR__ . '/../models/Notification.php';

                Notification::add(
                    $trajet['conducteur_id'],
                    "Nouvelle demande de réservation pour le trajet " .
                    htmlspecialchars($trajet['depart']) . " → " . htmlspecialchars($trajet['arrivee'])
                );
                $_SESSION['success'] = "Votre réservation a été envoyée !";

            } else {
                // AJOUT DU MESSAGE D'ERREUR SI DÉJÀ RÉSERVÉ
                $_SESSION['error'] = "Vous avez déjà une réservation en cours ou acceptée pour ce trajet.";
            }

            header("Location: index.php?page=reserver&id=" . $trajetId);
            exit;
        }

        // Extraction prénom conducteur
        $prenomConducteur = explode(" ", trim($trajet['conducteur_nom']));
        $prenomConducteur = ucfirst(strtolower($prenomConducteur[0]));

        // Passagers confirmés
        $passagersConfirmes = self::getAcceptedPassengers($trajetId);

        $successMessage = $_SESSION['success'] ?? "";
        unset($_SESSION['success']);

        // Récupération message d'erreur pour l'afficher dans la vue si nécessaire
        $errorMessage = $_SESSION['error'] ?? "";
        unset($_SESSION['error']);

        $trajet['is_superdriver'] = User::isSuperDriver($trajet['conducteur_id']);

        require __DIR__ . '/../views/reserver.php';
    }

    private static function getAcceptedPassengers(int $trajetId): array
    {
        global $pdo;

        $sql = $pdo->prepare("
            SELECT u.id, u.nom, u.avatar
            FROM reservations r
            JOIN users u ON u.id = r.passager_id
            WHERE r.trajet_id = ?
            AND r.statut = 'acceptee'
        ");
        $sql->execute([$trajetId]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
