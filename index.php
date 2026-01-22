<?php

session_start();

// Chargement de la BDD
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/helpers/date.php';

// auto loading des modèles 
spl_autoload_register(function($class) {
    if (file_exists(__DIR__ . '/app/models/' . $class . '.php')) {
        require_once __DIR__ . '/app/models/' . $class . '.php';
    }
    if (file_exists(__DIR__ . '/app/controllers/' . $class . '.php')) {
        require_once __DIR__ . '/app/controllers/' . $class . '.php';
    }
});

$page = $_GET['page'] ?? 'home';



if ($page === 'forgot') {
    $controller = new ForgotController();
    $controller->index();
    exit;
}

if ($page === 'reset') {
    $controller = new ResetController();
    $controller->index();
    exit;
}

if ($page === 'annuler_reservation') {
    require_once __DIR__ . '/app/controllers/AnnulerReservationController.php';
    (new AnnulerReservationController())->index();
    exit;
}

if ($page === 'home') {
    $controller = new HomeController();
    $controller->index();
    exit;
}

// accéder à "/" sans avoir ça : ?page=home
if ($page === '' || $page === 'index') {
    header("Location: index.php?page=home");
    exit;
}

if ($page === 'register') {
    $controller = new RegisterController();
    $controller->index();
    exit;
}

if ($page === 'connexion') {
    $controller = new LoginController();
    $controller->index();
    exit;
}

if ($page === 'clear_notifications') {
    require __DIR__ . '/app/controllers/ClearNotificationsController.php';
    (new ClearNotificationsController())->index();
    exit;
}

if ($page === 'profil') {
    $controller = new ProfilController();
    $controller->index();
    exit;
}

if ($page === 'change_email') {
    (new ChangeEmailController())->index();
    exit;
}

if ($page === 'change_email_confirm') {
    (new ChangeEmailConfirmController())->index();
    exit;
}

if ($page === 'voirprofil') {
    $controller = new VoirProfilController();
    $controller->index();
    exit;
}

if ($page === 'logout') {
    $controller = new LogoutController();
    $controller->index();
    exit;
}

if ($page === 'recherche') {
    $controller = new RechercheController();
    $controller->index();
    exit;
}

if ($page === 'reserver') {
    $controller = new ReserverController();
    $controller->index();
    exit;
}

if ($page === 'publier_trajet') {
    $controller = new PublierTrajetController();
    $controller->index();
    exit;
}

if ($page === 'faq') {
    $controller = new FaqController();
    $controller->index();
    exit;
}

if ($page === 'contact') {
    $controller = new ContactController();
    $controller->form();
    exit;
}

if ($page === 'contact_send') {
    $controller = new ContactController();
    $controller->send();
    exit;
}

if ($page === 'about') {
    $controller = new AboutController();
    $controller->index();
    exit;
}


if ($page === 'mestrajets') {
    (new MesTrajetsController())->index();
    exit;
}


if ($page === 'reponse_reservation') {
    (new ReponseReservationController())->index();
    exit;
}

if ($page === 'laisser_avis') {
    $controller = new LaisserAvisController();
    $controller->index();
    exit;
}

if ($page === 'admin') {
    $controller = new AdminController();
    $controller->index();
    exit;
}

if ($page === 'admin_faq') {
    $controller = new AdminFaqController();
    $controller->index();
    exit;
}

if ($page === 'cgu_mentions') {
    $controller = new LegalController();
    $controller->index();
    exit;
}

if ($page === 'admin_legal') {
    $controller = new AdminLegalController();
    $controller->index();
    exit;
}

if ($page === 'supprimer_trajet') {
    $controller = new SupprimerTrajetController();
    $controller->index();
    exit;
}

if ($page === 'verify_email') {
    require_once __DIR__ . '/app/controllers/VerifyEmailController.php';
    (new VerifyEmailController())->index();
    exit;
}

if ($page === 'verifnum') {
    $controller = new VerifyPhoneController();
    $controller->form();
    exit;
}

if ($page === 'verifnum_send') {
    $controller = new VerifyPhoneController();
    $controller->send();
    exit;
}

if ($page === 'verifnum_code') {
    $controller = new VerifyPhoneController();
    $controller->codeForm();
    exit;
}

if ($page === 'verifnum_check') {
    $controller = new VerifyPhoneController();
    $controller->check();
    exit;
}



// En cas d'erreur ou si aucune route existe
echo "Page inconnue.";