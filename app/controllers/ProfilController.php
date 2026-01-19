<?php

class ProfilController
{
    public function index()
    {
        global $pdo;

        // Vérif de session
        if (!isset($_SESSION["user"]["id"])) {
            header("Location: index.php?page=connexion");
            exit;
        }

        $userId = $_SESSION["user"]["id"];
        $isAdminView = false; // Par défaut

        // l’admin consulte un autre profil (via son panel)
        if (isset($_GET['id']) && $_SESSION['user']['role'] === 'admin') {
            $targetId = (int) $_GET['id'];

            // Si l’admin veut voir un autre utilisateur
            if ($targetId !== $userId) {
                $user = User::getById($targetId);

                if (!$user) {
                    $_SESSION['flash_error'] = "Utilisateur introuvable.";
                    header("Location: index.php?page=admin");
                    exit;
                }

                $isAdminView = true;
            } else {
                $user = User::getById($userId);
            }
        } else {
            $user = User::getById($userId);
        }

        $regions = [
            "Ile-de-France",
            "Auvergne-Rhône-Alpes",
            "Occitanie",
            "Provence-Alpes-Côte d'Azur",
            "Nouvelle-Aquitaine",
            "Hauts-de-France",
            "Grand Est",
            "Bretagne",
            "Normandie",
            "Pays de la Loire",
            "Bourgogne-Franche-Comté",
            "Centre-Val de Loire",
            "Corse",
            "Outre-mer"
        ];

        // Préférences utilisateur 
        $musiqueOn = !empty($user["musique"]);
        $fumeurOn  = !empty($user["fumeur"]);
        $animauxOn = !empty($user["animaux"]);

        // Historique rapide
        $history = User::getHistoriqueRapide($user["id"]);

        // Flash messages (à modif)
        $success = $_SESSION["flash_success"] ?? "";
        $error   = $_SESSION["flash_error"] ?? "";
        unset($_SESSION["flash_success"], $_SESSION["flash_error"]);

        if ($_SERVER["REQUEST_METHOD"] === "POST" && !$isAdminView) {

            // avatar
            if ($_POST["action"] === "update_avatar") {
                User::updateAvatar($user["id"], $_FILES["avatar"]);
                $_SESSION["flash_success"] = "Photo mise à jour !";
                header("Location: index.php?page=profil");
                exit;
            }

            // infos perso
            if ($_POST["action"] === "update_infos") {
                User::updateInfos($user["id"], [
                    "telephone"       => $_POST["telephone"],
                    "description"     => $_POST["description"],
                    "region"          => $_POST["region"],
                    "voiture_modele"  => $_POST["voiture_modele"] ?? null,
                    "voiture_couleur" => $_POST["voiture_couleur"] ?? null,
                    "musique"         => $_POST["musique"] ?? 0,
                    "fumeur"          => $_POST["fumeur"] ?? 0,
                    "animaux"         => $_POST["animaux"] ?? 0
                ]);

                $_SESSION["flash_success"] = "Informations mises à jour.";
                header("Location: index.php?page=profil");
                exit;
            }

            // identité
            if ($_POST["action"] === "upload_identite") {
                User::updateIdentity($user["id"], $_FILES["identite"]);
                $_SESSION["flash_success"] = "Document d'identité envoyé.";
                header("Location: index.php?page=profil");
                exit;
            }

            // permis
            if ($_POST["action"] === "upload_permis") {
                User::updatePermis($user["id"], $_FILES["permis"]);
                $_SESSION["flash_success"] = "Permis envoyé.";
                header("Location: index.php?page=profil");
                exit;
            }
        }

        // Calcul expiration permis 
        $left = null;
        if (!empty($user['permis_upload_at']) && !empty($user['conducteur_valide'])) {
            $uploadDate = new DateTime($user['permis_upload_at']);
            $expireDate = (clone $uploadDate)->modify('+7 days');
            $now = new DateTime();

            $interval = $now->diff($expireDate);
            $left = ($expireDate > $now) ? ceil($interval->days + 1) : 0;

            if ($expireDate < $now) {
                $upd = $pdo->prepare("
                    UPDATE users 
                    SET conducteur_valide = 0, 
                        conducteur_demande = 0,
                        role = 'passager'
                    WHERE id = ?
                ");
                $upd->execute([$user['id']]);

                $user['conducteur_valide'] = 0;
                $user['conducteur_demande'] = 0;
                $user['role'] = 'passager';

                $_SESSION['flash_error'] = "La validation conducteur a expiré. Merci de renvoyer le permis.";
            }
        }

        require __DIR__ . '/../views/profil.php';
    }
}