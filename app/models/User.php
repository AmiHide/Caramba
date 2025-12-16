<?php

class User
{
    public static function getById(int $id)
    {
        global $pdo;

        $sql = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $sql->execute([$id]);
        $user = $sql->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        if (empty($user['avatar'])) {
            $user['avatar'] = "user-icon.png";
        }

        $parts = explode(" ", trim($user["nom"]));
        $prenom = ucfirst(strtolower($parts[0]));
        $nomCaps = strtoupper(implode(" ", array_slice($parts, 1)));
        $user["nom_formate"] = trim($prenom . " " . $nomCaps);

        return $user;
    }


    public static function formatUserName(string $nom)
    {
        $parts = explode(" ", trim($nom));
        $prenom = ucfirst(strtolower($parts[0]));
        $nomCaps = strtoupper(implode(" ", array_slice($parts, 1)));
        return trim($prenom . " " . $nomCaps);
    }


    public static function updateAvatar(int $id, array $file)
    {
        global $pdo;

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            return false;
        }

        $fileName = "avatar_" . $id . "_" . uniqid() . "." . $ext;

        $uploadDir = __DIR__ . '/../../public/uploads/avatars/';

        if (!move_uploaded_file($file['tmp_name'], $uploadDir . $fileName)) {
            return false;
        }

        // Update DB
        $sql = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
        $sql->execute([$fileName, $id]);

        return $fileName;
    }


    public static function updateIdentity(int $id, array $file)
    {
        global $pdo;

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            return false;
        }

        $fileName = "identite_" . $id . "_" . uniqid() . "." . $ext;

        $uploadDir = __DIR__ . '/../../public/uploads/identite/';

        if (!move_uploaded_file($file['tmp_name'], $uploadDir . $fileName)) {
            return false;
        }

        $q = $pdo->prepare("UPDATE users SET preuve_identite = ? WHERE id = ?");
        $q->execute([$fileName, $id]);

        return $fileName;
    }


public static function updatePermis(int $id, array $file)
{
    global $pdo;

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $allowed = ['jpg', 'jpeg', 'png', 'pdf', 'webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        return false;
    }

    $fileName = "permis_" . $id . "_" . uniqid() . "." . $ext;

    $uploadDir = __DIR__ . '/../../public/uploads/permis/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0775, true);
    }

    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $fileName)) {
        return false;
    }

   $q = $pdo->prepare("
    UPDATE users 
    SET permis = ?, 
        conducteur_demande = 1, 
        permis_upload_at = NOW()
    WHERE id = ?
");

$permisPath = "/Caramba/public/uploads/permis/" . $fileName;
$q->execute([$permisPath, $id]);

return $permisPath;
}


    public static function updateInfos(int $id, array $data)
    {
        global $pdo;

        $q = $pdo->prepare("
            UPDATE users 
            SET 
                telephone = ?, 
                region = ?, 
                description = ?, 
                voiture_modele = ?, 
                voiture_couleur = ?, 
                musique = ?, 
                fumeur = ?, 
                animaux = ?
            WHERE id = ?
        ");

        return $q->execute([
            $data['telephone'],
            $data['region'],
            $data['description'],
            $data['voiture_modele'],
            $data['voiture_couleur'],
            $data['musique'],
            $data['fumeur'],
            $data['animaux'],
            $id
        ]);
    }


    public static function updatePreferences(int $id, array $prefs)
    {
        global $pdo;

        $q = $pdo->prepare("
            UPDATE users 
            SET musique = ?, 
                fumeur = ?, 
                animaux = ?
            WHERE id = ?
        ");

        return $q->execute([
            $prefs['musique'],
            $prefs['fumeur'],
            $prefs['animaux'],
            $id
        ]);
    }


    public static function updateVehicle(int $id, array $vehicule)
    {
        global $pdo;

        $q = $pdo->prepare("
            UPDATE users 
            SET voiture_modele = ?, 
                voiture_couleur = ?
            WHERE id = ?
        ");

        return $q->execute([
            $vehicule['modele'],
            $vehicule['couleur'],
            $id
        ]);
    }

    public static function isDriverValidated(array $user): bool
    {
        return isset($user['conducteur_valide']) && (int)$user['conducteur_valide'] === 1;
    }

    public static function isDriverPending(array $user): bool
    {
        return isset($user['conducteur_demande']) && (int)$user['conducteur_demande'] === 1
               && (int)$user['conducteur_valide'] === 0;
    }


    public static function getLicenceExpirationInfo(array $user)
    {
        if (empty($user['permis']) || empty($user['permis_expire'])) {
            return [
                "expired" => false,
                "days_left" => null,
                "expire_date" => null
            ];
        }

        $expire = strtotime($user['permis_expire']);
        $today = strtotime(date("Y-m-d"));
        $diff = ($expire - $today) / 86400; // jours

        return [
            "expired" => $diff < 0,
            "days_left" => (int)$diff,
            "expire_date" => $user['permis_expire']
        ];
    }

    public static function getTrajetsConducteur(int $userId)
    {
        global $pdo;

        $sql = $pdo->prepare("
            SELECT t.*, 
                   COUNT(r.id) AS total_reservations,
                   SUM(CASE WHEN r.statut = 'acceptee' THEN r.places_reservees ELSE 0 END) AS places_prises
            FROM trajets t
            LEFT JOIN reservations r ON t.id = r.trajet_id
            WHERE t.conducteur_id = ?
            GROUP BY t.id
            ORDER BY t.date_depart DESC, t.heure_depart DESC
        ");

        $sql->execute([$userId]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }



    public static function getTrajetsPassager(int $userId)
    {
        global $pdo;

        $sql = $pdo->prepare("
            SELECT r.*, 
                   t.*, 
                   u.nom AS conducteur_nom,
                   u.avatar AS conducteur_avatar
            FROM reservations r
            JOIN trajets t ON r.trajet_id = t.id
            JOIN users u ON u.id = t.conducteur_id
            WHERE r.passager_id = ?
            ORDER BY t.date_depart DESC, t.heure_depart DESC
        ");

        $sql->execute([$userId]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function isPastRide(string $date, string $heure = "23:59")
    {
        $datetime = strtotime("$date $heure");
        return $datetime < time();
    }


    public static function getAvisForUser(int $userId)
    {
        global $pdo;

        $sql = $pdo->prepare("
            SELECT a.*, 
                   u.nom AS auteur_nom,
                   u.avatar AS auteur_avatar
            FROM avis a
            JOIN users u ON u.id = 
                CASE 
                    WHEN a.auteur_role = 'conducteur' THEN a.conducteur_id
                    ELSE a.passager_id
                END
            WHERE a.cible_id = ?
            ORDER BY a.date_avis DESC
        ");

        $sql->execute([$userId]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function getMoyenneAvis(int $userId)
    {
        global $pdo;

        $q = $pdo->prepare("
            SELECT AVG(note) AS moyenne
            FROM avis
            WHERE cible_id = ?
        ");
        $q->execute([$userId]);

        $row = $q->fetch(PDO::FETCH_ASSOC);
        return $row['moyenne'] ? round($row['moyenne'], 1) : 0;
    }

    public static function countTrajetsConducteur(int $userId)
    {
        global $pdo;

        $q = $pdo->prepare("SELECT COUNT(*) FROM trajets WHERE conducteur_id = ?");
        $q->execute([$userId]);

        return (int)$q->fetchColumn();
    }

    
    public static function getPublicProfile(int $id)
    {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public static function getByEmail(string $email)
    {
        global $pdo;
        $q = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $q->execute([$email]);
        return $q->fetch(PDO::FETCH_ASSOC);
    }

    public static function getByResetToken(string $token)
    {
        global $pdo;
        $q = $pdo->prepare("SELECT * FROM users WHERE reset_token = ?");
        $q->execute([$token]);
        return $q->fetch(PDO::FETCH_ASSOC);
    }

    public static function storeEmailResetToken(string $email, string $token, string $expire)
    {
        global $pdo;

        $q = $pdo->prepare("
            UPDATE users
            SET reset_token = ?, reset_expire = ?
            WHERE email = ?
        ");

        return $q->execute([$token, $expire, $email]);
    }

    public static function emailExistsForOther(string $email, int $userId)
    {
        global $pdo;
        $q = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $q->execute([$email, $userId]);
        return $q->fetch();
    }

    public static function updateEmail(int $id, string $email)
    {
        global $pdo;
        $q = $pdo->prepare("
            UPDATE users
            SET email = ?, reset_token = NULL, reset_expire = NULL
            WHERE id = ?
        ");
        return $q->execute([$email, $id]);
    }



    public static function findByEmail(string $email)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function setResetToken(string $email, string $token, string $expire)
    {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expire = ? WHERE email = ?");
        return $stmt->execute([$token, $expire, $email]);
    }

    public static function findByToken(string $token)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ?");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updatePassword(int $id, string $hash)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            UPDATE users 
            SET mot_de_passe = ?, reset_token = NULL, reset_expire = NULL
            WHERE id = ?
        ");
        return $stmt->execute([$hash, $id]);
    }

    public static function existsByEmailOrPseudo(string $email, string $pseudo): bool
    {
        global $pdo;

        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR pseudo = ? LIMIT 1");
        $stmt->execute([$email, $pseudo]);
        return (bool) $stmt->fetch();
    }

    public static function insertFromRegister(array $data): void
    {
        global $pdo;

        $stmt = $pdo->prepare("
            INSERT INTO users 
            (nom, email, mot_de_passe, date_inscription, avatar, sexe, date_naissance, telephone, region, preuve_identite, permis, pseudo, conducteur_demande, conducteur_valide, role)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['nom_complet'],
            $data['email'],
            $data['password_hash'],
            $data['date_inscription'],
            $data['avatar'],
            $data['sexe'],
            $data['naissance'],
            $data['tel'],
            $data['region'],
            $data['preuve_identite'],
            $data['permis'],
            $data['pseudo'],
            $data['conducteur_demande'],
            $data['conducteur_valide'],
            $data['role']
        ]);
    }
    public static function getHistoriqueRapide(int $userId)
    {
    global $pdo;

    $sql1 = "
        SELECT 
            id, depart, arrivee, prix, date_depart,
            'conducteur' AS role
        FROM trajets
        WHERE conducteur_id = ?
        ORDER BY date_depart DESC
        LIMIT 4
    ";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute([$userId]);
    $conducteurHistory = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    $sql2 = "
        SELECT 
            t.id, t.depart, t.arrivee, t.prix, t.date_depart,
            'passager' AS role
        FROM reservations r
        JOIN trajets t ON r.trajet_id = t.id
        WHERE r.passager_id = ?
        ORDER BY t.date_depart DESC
        LIMIT 4
    ";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute([$userId]);
    $passagerHistory = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    $history = array_merge($conducteurHistory, $passagerHistory);

    foreach ($history as &$h) {
        $h['future'] = (strtotime($h['date_depart']) > time());
    }

    usort($history, function ($a, $b) {
        return strtotime($b['date_depart']) - strtotime($a['date_depart']);
    });

    return array_slice($history, 0, 4);
    }

    public static function mapBasicByIds(array $ids): array
    {
        if (empty($ids)) return [];
        global $pdo;

        $in = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT id, pseudo, nom, email, avatar, role
                FROM users
                WHERE id IN ($in)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($ids);
        $map = [];
        foreach ($stmt->fetchAll() as $u) {
            $map[(int)$u['id']] = $u;
        }
        return $map;
    }

    public static function getAllUsers(): array
    {
        global $pdo;

        $sql = $pdo->query("
            SELECT id, nom, email, telephone, role, conducteur_demande, conducteur_valide, date_inscription 
            FROM users
            ORDER BY date_inscription DESC
        ");
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteUser(int $id): void
    {
        global $pdo;

        $q = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $q->execute([$id]);
    }

    public static function updateRole(int $id, string $role): void
    {

    global $pdo;

    $allowed = ["passager", "conducteur", "premium", "pro", "admin"];
    if (!in_array($role, $allowed)) {
        throw new Exception("Rôle invalide");
    }

    $sql = $pdo->prepare("
        UPDATE users 
        SET role = ?, 
            conducteur_valide = IF(? = 'conducteur', 1, 0),
            conducteur_demande = 0
        WHERE id = ?
    ");
    $sql->execute([$role, $role, $id]);
    }

    public static function getPendingConducteurs(): array
    {
        global $pdo;

        $q = $pdo->query("
            SELECT id, nom, email, permis, conducteur_demande, conducteur_valide 
            FROM users 
            WHERE conducteur_demande = 1 AND conducteur_valide = 0
            ORDER BY id DESC
        ");
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function validateConducteur(int $id): void
    {
        global $pdo;

        $q = $pdo->prepare("
            UPDATE users 
            SET conducteur_valide = 1, 
                conducteur_demande = 0, 
                role = 'conducteur',
                permis_upload_at = NOW()
            WHERE id = ?
        ");
        $q->execute([$id]);
    }

    public static function refuseConducteur(int $id): void
    {
        global $pdo;

        $q = $pdo->prepare("
            UPDATE users 
            SET conducteur_valide = 0, conducteur_demande = 0, role = 'passager'
            WHERE id = ?
        ");
        $q->execute([$id]);
    }


public static function isSuperDriver(int $userId): bool
{
    $trajetsRealises = Trajet::getTrajetsRealisesConducteur($userId);

    return count($trajetsRealises) >= 5;  
}
}
