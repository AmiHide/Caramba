<?php

class HomeController {

    public function index() {
        global $pdo;

        $toast = "";
        if (isset($_SESSION["login_success"])) {
            $toast = $_SESSION["login_success"];
            unset($_SESSION["login_success"]);
        }

        // Charger toutes les villes
        $villes = [];
        $req = $pdo->query("SELECT nom FROM villes ORDER BY nom ASC");
        if ($req) {
            $villes = $req->fetchAll(PDO::FETCH_ASSOC);
        }

        // Charger les avis récents
        $sqlAvis = $pdo->query("
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
            LIMIT 6
        ");
        $avisList = $sqlAvis->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/home.php';
    }
}