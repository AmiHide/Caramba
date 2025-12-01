<?php

class Reservation
{


    // Vérif si une réservation est déjà présente
    public static function existsForUser(int $userId, int $trajetId): bool
    {
        global $pdo;

        $sql = $pdo->prepare("
            SELECT COUNT(*)
            FROM reservations
            WHERE passager_id = ? AND trajet_id = ?
        ");
        $sql->execute([$userId, $trajetId]);

        return $sql->fetchColumn() > 0;
    }



    // Crée une réservation en attente
    public static function createPending(int $trajetId, int $userId, int $places, string $expireAt): void
    {
        global $pdo;

        $sql = $pdo->prepare("
            INSERT INTO reservations (trajet_id, passager_id, places_reservees, statut, expire_at)
            VALUES (?, ?, ?, 'en_attente', ?)
        ");

        $sql->execute([$trajetId, $userId, $places, $expireAt]);
    }


    // Récup les réservations du passager
    public static function getMesReservations(int $userId): array
    {
        global $pdo;

        $sql = $pdo->prepare("
            SELECT r.*,
                   t.depart, t.arrivee, t.date_depart, t.heure_depart,
                   t.description, t.prix,
                    t.conducteur_id, 
                   u.nom AS conducteur_nom,
                   u.avatar AS conducteur_avatar
            FROM reservations r
            JOIN trajets t ON t.id = r.trajet_id
            JOIN users u ON u.id = t.conducteur_id
            WHERE r.passager_id = ?
            ORDER BY t.date_depart DESC, t.heure_depart DESC
        ");

        $sql->execute([$userId]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }



    // Récupère les passagers en attente d'un trajet
    public static function getPassagersEnAttente(int $trajetId): array
    {
        global $pdo;

        $sql = $pdo->prepare("
            SELECT r.id, r.passager_id, r.places_reservees, r.expire_at,
                   u.nom, u.avatar, u.pseudo
            FROM reservations r
            JOIN users u ON u.id = r.passager_id
            WHERE r.trajet_id = ?
              AND r.statut = 'en_attente'
            ORDER BY r.date_reservation ASC
        ");

        $sql->execute([$trajetId]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function marquerExpirees(): void
    {
        global $pdo;

        $sql = $pdo->prepare("
            UPDATE reservations
            SET statut = 'expiree'
            WHERE statut = 'en_attente'
              AND expire_at < NOW()
        ");

        $sql->execute();
    }


    public static function accepter(int $resId, int $trajetId, int $placesRestantes): bool
    {
        global $pdo;


        $r = $pdo->prepare("SELECT * FROM reservations WHERE id = ?");
        $r->execute([$resId]);
        $reservation = $r->fetch(PDO::FETCH_ASSOC);

        if (!$reservation) return false;

        $placesReservees = intval($reservation["places_reservees"]);

        if ($placesReservees > $placesRestantes) {
            return false;
        }

        try {
            $pdo->beginTransaction();

            $update = $pdo->prepare("
                UPDATE reservations
                SET statut = 'acceptee'
                WHERE id = ?
            ");
            $update->execute([$resId]);

            $updatePlaces = $pdo->prepare("
                UPDATE trajets
                SET places_disponibles = places_disponibles - ?
                WHERE id = ?
            ");
            $updatePlaces->execute([$placesReservees, $trajetId]);

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }

    public static function refuser(int $resId): bool
    {
        global $pdo;

        $sql = $pdo->prepare("
            UPDATE reservations
            SET statut = 'refusee'
            WHERE id = ?
        ");
        return $sql->execute([$resId]);
    }

    public static function getAcceptedPassengers(int $trajetId): array
    {
        global $pdo;

        $sql = $pdo->prepare("
            SELECT u.id, u.nom, u.avatar, u.telephone
            FROM reservations r
            JOIN users u ON u.id = r.passager_id
            WHERE r.trajet_id = ?
              AND r.statut = 'acceptee'
        ");

        $sql->execute([$trajetId]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}