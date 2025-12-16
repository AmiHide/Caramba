<?php

class LaisserAvisController
{
    public function index()
    {

        global $pdo;

        if (!isset($_SESSION["user"]["id"])) {
            header("Location: index.php?page=connexion");
            exit;
        }

        $user_id = $_SESSION["user"]["id"];
        $trajet_id = $_GET["trajet_id"] ?? 0;
        $mode = $_GET["mode"] ?? "";
        $index = intval($_GET["index"] ?? 0);

        if (!$trajet_id || !in_array($mode, ["conducteur", "passager"])) {
            die("Paramètres invalides.");
        }

        // côté conducteur pour noter les passagers
        if ($mode === "conducteur") {
            $stmt = $pdo->prepare("
                SELECT u.id AS passager_id, u.nom, u.pseudo
                FROM reservations r
                JOIN users u ON u.id = r.passager_id
                JOIN trajets t ON t.id = r.trajet_id
                WHERE r.trajet_id = ? AND r.statut = 'acceptee' AND t.conducteur_id = ?
                ORDER BY u.nom ASC
            ");
            $stmt->execute([$trajet_id, $user_id]);
            $listePassagers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$listePassagers) {
                $_SESSION["flash_error"] = "Aucun passager à noter pour ce trajet.";
                header("Location: index.php?page=mestrajets");
                exit;
            }

            if (!isset($listePassagers[$index])) {
                $_SESSION["flash_success"] = "Tous les avis ont été enregistrés.";
                header("Location: index.php?page=mestrajets");
                exit;
            }

            $cible = $listePassagers[$index];
            $cible_id = $cible["passager_id"];

            // Vérifie si déjà noté
            $check = $pdo->prepare("
                SELECT id FROM avis
                WHERE trajet_id = ? AND conducteur_id = ? AND passager_id = ? AND auteur_role = 'conducteur'
            ");
            $check->execute([$trajet_id, $user_id, $cible_id]);

            if ($check->fetch()) {
                header("Location: index.php?page=laisser_avis&trajet_id=$trajet_id&mode=conducteur&index=" . ($index + 1));
                exit;
            }
        }

        
        //côté passager(s) vers le conducteur
        else {
            $stmt = $pdo->prepare("
                SELECT u.id AS conducteur_id, u.nom
                FROM trajets t
                JOIN users u ON u.id = t.conducteur_id
                WHERE t.id = ?
            ");
            $stmt->execute([$trajet_id]);
            $cible = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$cible) {
                $_SESSION["flash_error"] = "Conducteur introuvable.";
                header("Location: index.php?page=mestrajets");
                exit;
            }

            $cible_id = $cible["conducteur_id"];

            // Vérifie si déjà noté
            $check = $pdo->prepare("
                SELECT id FROM avis
                WHERE trajet_id = ? AND conducteur_id = ? AND passager_id = ? AND auteur_role = 'passager'
            ");
            $check->execute([$trajet_id, $cible_id, $user_id]);

            if ($check->fetch()) {
                $_SESSION["flash_error"] = "Vous avez déjà laissé un avis pour ce trajet.";
                header("Location: index.php?page=mestrajets");
                exit;
            }
        }

        // formulaire
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $note = intval($_POST["note"] ?? 0);
            $commentaire = trim($_POST["commentaire"] ?? "");

            if ($note < 1 || $note > 5) {
                $error = "Note invalide.";
            } elseif (strlen($commentaire) < 5) {
                $error = "Le commentaire doit contenir au moins 5 caractères.";
            } else {
                $insert = $pdo->prepare("
                    INSERT INTO avis (conducteur_id, passager_id, trajet_id, note, commentaire, auteur_role)
                    VALUES (?, ?, ?, ?, ?, ?)
                ");

                if ($mode === "conducteur") {
                    $insert->execute([$user_id, $cible_id, $trajet_id, $note, $commentaire, "conducteur"]);
                    header("Location: index.php?page=laisser_avis&trajet_id=$trajet_id&mode=conducteur&index=" . ($index + 1));
                    exit;
                } else {
                    $insert->execute([$cible_id, $user_id, $trajet_id, $note, $commentaire, "passager"]);
                    header("Location: index.php?page=mestrajets");
                    exit;
                }
            }
        }

        require __DIR__ . '/../views/laisser_avis.php';
    }
}