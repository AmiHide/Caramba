<?php

class Trajet
{
    public static function search(array $filters)
    {
        global $pdo;

        $query = "
            SELECT t.*, u.nom, u.avatar, u.pseudo
            FROM trajets t
            JOIN users u ON u.id = t.conducteur_id
            WHERE t.depart = :depart
              AND t.arrivee = :arrivee
              AND t.date_depart = :date
              AND t.places_disponibles >= :passagers
              AND (
                    t.date_depart > CURDATE()
                 OR (t.date_depart = CURDATE() AND t.heure_depart > CURTIME())
              )
        ";

        $params = [
            ':depart'    => $filters['depart'],
            ':arrivee'   => $filters['arrivee'],
            ':date'      => $filters['date'],
            ':passagers' => $filters['passagers'],
        ];

        // Filtres préférences 
        if (!empty($filters["musique"])) {
            $query .= " AND u.musique = 1 ";
        }

        if (!empty($filters["fumeur"])) {
            $query .= " AND u.fumeur = 1 ";
        }

        if (!empty($filters["animaux"])) {
            $query .= " AND u.animaux = 1 ";
        }

        // Prix max 
        if (!empty($filters["prix_max"])) {
            $query .= " AND t.prix <= :prix_max";
            $params[":prix_max"] = $filters["prix_max"];
        }

        // Tri 
        if (!empty($filters["tri"])) {
            switch ($filters["tri"]) {
                case "prix_asc":
                    $query .= " ORDER BY t.prix ASC";
                    break;

                case "prix_desc":
                    $query .= " ORDER BY t.prix DESC";
                    break;

                case "recents":
                default:
                    $query .= " ORDER BY t.date_publication DESC";
                    break;
            }
        } else {
            $query .= " ORDER BY t.date_publication DESC";
        }

        $sql = $pdo->prepare($query);
        $sql->execute($params);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByIdWithConducteur(int $id)
    {
    global $pdo;

    $q = $pdo->prepare("
        SELECT t.*, 
               u.nom AS conducteur_nom, 
               u.avatar AS conducteur_avatar, 
               u.id AS conducteur_id,
               u.description, 
               u.musique, 
               u.fumeur, 
               u.animaux, 
               u.voiture_modele, 
               u.voiture_couleur
        FROM trajets t
        JOIN users u ON u.id = t.conducteur_id
        WHERE t.id = ?
    ");
    $q->execute([$id]);
    return $q->fetch(PDO::FETCH_ASSOC);
    }

public static function getPublicHistory(int $userId)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT 
            t.depart, t.arrivee, t.prix, t.date_depart, t.heure_depart,
            CASE WHEN t.conducteur_id = :id_role THEN 'conducteur' ELSE 'passager' END AS role,
            CASE WHEN CONCAT(t.date_depart, ' ', t.heure_depart) > NOW()
                 THEN 1 ELSE 0 END AS future
        FROM trajets t
        LEFT JOIN reservations r ON r.trajet_id = t.id
        WHERE t.conducteur_id = :id_conducteur OR r.passager_id = :id_passager
        ORDER BY t.date_depart DESC
        LIMIT 3
    ");

    $stmt->execute([
        'id_role'       => $userId,
        'id_conducteur' => $userId,
        'id_passager'   => $userId,
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public static function countTrajetsConducteur(int $userId)
    {
        global $pdo;

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM trajets WHERE conducteur_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }

    //Récup les trajets d’un conducteur (à venir)
    public static function getTrajetsConducteur(int $userId): array
    {
        global $pdo;

        $sql = $pdo->prepare("
            SELECT *
            FROM trajets
            WHERE conducteur_id = ?
            AND (
                date_depart > CURDATE()
                OR (date_depart = CURDATE() AND heure_depart > CURTIME())
            )
            ORDER BY date_depart ASC, heure_depart ASC
        ");
        $sql->execute([$userId]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    //Récup les trajets futurs pov du passager
    public static function getTrajetsFutursAsPassager(int $userId): array
    {
        global $pdo;

        $sql = $pdo->prepare("
            SELECT r.*, t.*, u.nom AS conducteur_nom, u.avatar AS conducteur_avatar, u.telephone AS conducteur_telephone
            FROM reservations r
            JOIN trajets t ON t.id = r.trajet_id
            JOIN users u ON u.id = t.conducteur_id
            WHERE r.passager_id = ?
              AND r.statut = 'acceptee'
              AND (
                    t.date_depart > CURDATE()
                 OR (t.date_depart = CURDATE() AND t.heure_depart > CURTIME())
              )
            ORDER BY t.date_depart ASC, t.heure_depart ASC
        ");
        $sql->execute([$userId]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }


    //Récup les trajets futurs du conducteur
    public static function getTrajetsFutursAsConducteur(int $userId): array
    {
        global $pdo;

        $sql = $pdo->prepare("
            SELECT *
            FROM trajets
            WHERE conducteur_id = ?
              AND (
                    date_depart > CURDATE()
                 OR (date_depart = CURDATE() AND heure_depart > CURTIME())
              )
            ORDER BY date_depart ASC, heure_depart ASC
        ");
        $sql->execute([$userId]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    //Récup les trajets réalisés du conducteur
    public static function getTrajetsRealisesConducteur(int $userId): array
    {
        global $pdo;

        $sql = $pdo->prepare("
            SELECT *
            FROM trajets
            WHERE conducteur_id = ?
              AND (
                    date_depart < CURDATE()
                 OR (date_depart = CURDATE() AND heure_depart < CURTIME())
              )
            ORDER BY date_depart DESC, heure_depart DESC
        ");
        $sql->execute([$userId]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    //Récup les trajets réalisés pov passager
    public static function getTrajetsRealisesPassager(int $userId): array
    {
        global $pdo;

        $sql = $pdo->prepare("
            SELECT r.*, t.*, u.nom AS conducteur_nom, u.avatar AS conducteur_avatar
            FROM reservations r
            JOIN trajets t ON t.id = r.trajet_id
            JOIN users u ON u.id = t.conducteur_id
            WHERE r.passager_id = ?
              AND r.statut = 'acceptee'
              AND (
                    t.date_depart < CURDATE()
                 OR (t.date_depart = CURDATE() AND t.heure_depart < CURTIME())
              )
            ORDER BY t.date_depart DESC, t.heure_depart DESC
        ");
        $sql->execute([$userId]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function isConducteurAllowed(int $userId): bool
    {
    global $pdo;

    // Vérif que c'est uniquement le conducteur
    $sql = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $sql->execute([$userId]);
    $role = $sql->fetchColumn();

    return ($role === 'conducteur');
    }

    public static function getVilles(): array
    {
        global $pdo;

        $sql = $pdo->query("
            SELECT id, nom
            FROM villes
            ORDER BY nom ASC
        ");

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function isProfilConducteurComplet(int $userId): bool
    {
        global $pdo;

        $sql = $pdo->prepare("
            SELECT telephone, voiture_modele, voiture_couleur, description
            FROM users
            WHERE id = ? AND role = 'conducteur'
        ");
        $sql->execute([$userId]);
        $profil = $sql->fetch(PDO::FETCH_ASSOC);

        if (!$profil) {
            return false;
        }

        $requiredFields = ['telephone', 'voiture_modele', 'voiture_couleur', 'description'];

        foreach ($requiredFields as $field) {
            if (empty($profil[$field])) {
                return false;
            }
        }

        return true; 
    }

    public static function insert(array $data): bool
    {
    global $pdo;

    $sql = $pdo->prepare("
        INSERT INTO trajets 
        (conducteur_id, depart, arrivee, date_depart, heure_depart, places_disponibles, prix, description, date_publication)
        VALUES (:conducteur_id, :depart, :arrivee, :date_depart, :heure_depart, :places_disponibles, :prix, :description, NOW())
    ");

    return $sql->execute([
        ':conducteur_id'      => $data['conducteur_id'],
        ':depart'             => $data['depart'],
        ':arrivee'            => $data['arrivee'],
        ':date_depart'        => $data['date_depart'],
        ':heure_depart'       => $data['heure_depart'],
        ':places_disponibles' => $data['places'],
        ':prix'               => $data['prix'],
        ':description'        => $data['description'],
    ]);
    }

    public static function getAllTrajets(): array
    {
        global $pdo;

        $sql = $pdo->query("
            SELECT t.id, t.depart, t.arrivee, t.date_depart, t.heure_depart, t.prix, 
                u.nom AS conducteur_nom
            FROM trajets t
            JOIN users u ON u.id = t.conducteur_id
            ORDER BY t.date_depart DESC
        ");
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteTrajet(int $id): bool
    {
        global $pdo;

        $stmt = $pdo->prepare("DELETE FROM trajets WHERE id = ?");
        return $stmt->execute([$id]);
    }


    /**
     * Récupère le top 5 des trajets les plus proposés (groupés par Depart -> Arrivee)
     */
    public static function getTopTrajets($limit = 5)
    {
        global $pdo; // Utilisation de la globale $pdo au lieu de Database::getInstance()
        
        $sql = "SELECT depart, arrivee, COUNT(*) as total
                FROM trajets
                GROUP BY depart, arrivee
                ORDER BY total DESC
                LIMIT :limit";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
