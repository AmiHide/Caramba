<?php

class RechercheController
{
    public function index()
    {
        $villes = Ville::getAll();

        // Vars recherche
        $depart    = $_GET['depart']    ?? "";
        $arrivee   = $_GET['arrivee']   ?? "";
        $date      = $_GET['date']      ?? "";
        $passagers = $_GET['passagers'] ?? 1;

        $filters = [
            "depart"    => $depart,
            "arrivee"   => $arrivee,
            "date"      => $date,
            "passagers" => $passagers,
            "prix_max"  => $_GET["prix_max"] ?? null,
            "tri"       => $_GET["tri"] ?? null,
            "musique"   => $_GET["musique"] ?? null,
            "fumeur"    => $_GET["fumeur"] ?? null,
            "animaux"   => $_GET["animaux"] ?? null,
        ];

        $trajets = [];

        if (!$depart && !$arrivee && !$date) {
            $trajets = Trajet::getAllFuture();
        }

        elseif ($depart && $arrivee && $date) {
            $trajets = Trajet::search($filters);
        }

        require __DIR__ . '/../views/recherche.php';
    }
}
