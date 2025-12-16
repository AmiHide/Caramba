<?php

class Avis {

    public static function getRecents(int $limit = 6) {
        global $pdo;

        $limit = (int)$limit;

        $sql = "
        SELECT a.*, 
               u.nom AS auteur_nom, u.avatar AS auteur_avatar,
               t.depart, t.arrivee
        FROM avis a
        JOIN users u ON u.id = 
            CASE 
                WHEN a.auteur_role = 'passager' THEN a.passager_id
                ELSE a.conducteur_id
            END
        JOIN trajets t ON t.id = a.trajet_id
        ORDER BY a.date_avis DESC
        LIMIT $limit
        ";

        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getStats(int $userId)
    {
        global $pdo;

        $stmt = $pdo->prepare("
            SELECT AVG(note) AS moyenne, COUNT(*) AS total
            FROM avis
            WHERE 
                (conducteur_id = ? AND auteur_role = 'passager')
             OR (passager_id = ? AND auteur_role = 'conducteur')
        ");
        $stmt->execute([$userId, $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getList(int $userId)
    {
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT 
            a.*, 
            u.nom AS auteur_nom, 
            u.avatar AS auteur_avatar,
            t.depart AS ville_depart, 
            t.arrivee AS ville_arrivee
        FROM avis a
        JOIN users u ON (
            (a.auteur_role = 'conducteur' AND u.id = a.conducteur_id) OR
            (a.auteur_role = 'passager'   AND u.id = a.passager_id)
        )
        JOIN trajets t ON t.id = a.trajet_id
        WHERE 
              (a.conducteur_id = :id_conducteur AND a.auteur_role = 'passager')
           OR (a.passager_id   = :id_passager   AND a.auteur_role = 'conducteur')
        ORDER BY a.date_avis DESC
    ");

    $stmt->execute([
        'id_conducteur' => $userId,
        'id_passager'   => $userId,
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
