<?php

class Ville {

    public static function getAll() {
        global $pdo;

        $stmt = $pdo->query("SELECT nom FROM villes ORDER BY nom ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
