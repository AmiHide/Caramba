<?php

class PublierTrajetController
{
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=connexion");
            exit;
        }

        $userId = $_SESSION['user']['id'];

        // Vérifier conducteur
        if (!Trajet::isConducteurAllowed($userId)) {
            $_SESSION['flash_error'] = "Vous devez être conducteur pour publier un trajet.";
            header("Location: index.php?page=profil");
            exit;
        }

        // Vérifier profil complet
        if (!Trajet::isProfilConducteurComplet($userId)) {
            $_SESSION['flash_error'] = "Votre profil conducteur est incomplet. Complétez vos informations avant de publier un trajet.";
            header("Location: index.php?page=profil");
            exit;
        }

        // Charger villes
        $villes = Trajet::getVilles();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            // récup noms des villes 
            $depart = trim($_POST['depart'] ?? '');
            $arrivee = trim($_POST['arrivee'] ?? '');

            if ($depart === '' || $arrivee === '') {
                $_SESSION['flash_error'] = "Les villes sont obligatoires.";
                header("Location: index.php?page=publier_trajet");
                exit;
            }

            if ($depart === $arrivee) {
                $_SESSION['flash_error'] = "Vous devez choisir deux villes différentes.";
                header("Location: index.php?page=publier_trajet");
                exit;
            }

            $data = [
                'conducteur_id' => $userId,
                'depart'        => $depart,
                'arrivee'       => $arrivee,
                'date_depart'   => $_POST['date_depart'],
                'heure_depart'  => $_POST['heure_depart'],
                'places'        => intval($_POST['places']),
                'prix'          => floatval($_POST['prix']),
                'description'   => trim($_POST['description'])
            ];

            if (Trajet::insert($data)) {
                $_SESSION['flash_success'] = "Trajet publié avec succès !";
                header("Location: index.php?page=mestrajets");
                exit;
            } else {
                $_SESSION['flash_error'] = "Erreur lors de la publication.";
            }
        }

        require __DIR__ . '/../views/publier_trajet.php';
    }
}