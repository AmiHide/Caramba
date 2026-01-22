<?php

class AdminController
{
    public function index()
    {
        // accès que admin 
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: index.php?page=connexion");
            exit;
        }

        // Récup des données principales
        $users = User::getAllUsers();
        $trajets = Trajet::getAllTrajets();
        $demandesConducteurs = User::getPendingConducteurs();

        $reservations = Reservation::getAllReservations();

        if (isset($_GET['action'], $_GET['id'])) {
            $id = (int) $_GET['id'];
            $action = $_GET['action'];

            switch ($action) {
                case 'delete_user':
                    User::deleteUser($id);
                    $_SESSION['flash_success'] = "Utilisateur supprimé avec succès.";
                    break;

                case 'delete_trajet':
                    Trajet::deleteTrajet($id);
                    $_SESSION['flash_success'] = "Trajet supprimé avec succès.";
                    break;

                case 'validate_conducteur':
                    User::validateConducteur($id);
                    $_SESSION['flash_success'] = "Conducteur validé avec succès.";
                    break;

                case 'refuse_conducteur':
                    User::refuseConducteur($id);
                    $_SESSION['flash_error'] = "Conducteur refusé.";
                    break;

                case 'change_role_admin':
                    User::updateRole($id, 'admin');
                    $_SESSION['flash_success'] = "L'utilisateur est désormais administrateur.";
                    break;

                case 'change_role_passager':
                    User::updateRole($id, 'passager');
                    $_SESSION['flash_success'] = "L'utilisateur est désormais passager.";
                    break;

                case 'change_role_conducteur':
                    User::updateRole($id, 'conducteur');
                    $_SESSION['flash_success'] = "L'utilisateur est désormais conducteur.";
                    break;
            }

            header("Location: index.php?page=admin");
            exit;
        }

        require __DIR__ . '/../views/admin/index.php';
    }
}