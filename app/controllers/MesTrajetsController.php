<?php

class MesTrajetsController
{
    public function index()
    {
        if (!isset($_SESSION["user"]["id"])) {
            header("Location: index.php?page=connexion");
            exit;
        }

        $user_id   = $_SESSION["user"]["id"];
        $user_role = $_SESSION["user"]["role"];

        $reservations = Reservation::getMesReservations($user_id);

        $trajets_conducteur = Trajet::getTrajetsConducteur($user_id);

        // Récupération des passagers en attente pour chaque trajet conducteur
        $passagers_attente = [];
        foreach ($trajets_conducteur as $t) {
            $passagers_attente[$t['id']] = Reservation::getPassagersEnAttente($t['id']);
        }

        $trajets_futurs  = Trajet::getTrajetsFutursAsPassager($user_id);
        $trajets_futurs_conducteur = Trajet::getTrajetsFutursAsConducteur($user_id);


        $trajets_realises_passager   = Trajet::getTrajetsRealisesPassager($user_id);
        $trajets_realises_conducteur = Trajet::getTrajetsRealisesConducteur($user_id);


        $trajets_realises = array_merge(
            $trajets_realises_passager,
            $trajets_realises_conducteur
        );

        require __DIR__ . '/../views/mestrajets.php';
    }
}