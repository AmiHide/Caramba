<?php
// Caramba/app/models/Mailer.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Chemins vers PHPMailer (ajustez si nécessaire)
require_once __DIR__ . '/../../PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../../PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../../PHPMailer-master/src/SMTP.php';

class Mailer {

    // Configuration commune pour éviter de répéter les mots de passe
    private static function getConfiguredMailer() {
        // Chargement des informations d'environement 

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        
        $mail->Username   = ['email'];
        $mail->Password   = ['password']; 

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->setFrom( ['email'], 'Caramba');
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        
        return $mail;
    }

    // Fonction pour l'inscription (déjà existante, améliorée)
    public static function sendVerification($email, $nom, $token) {
        try {
            $mail = self::getConfiguredMailer();
            $mail->addAddress($email, $nom);

            $link = "http://localhost/Caramba/index.php?page=verify_email&token=" . $token;

            $mail->Subject = "Activez votre compte Caramba";
            $mail->Body    = "
                <h1>Bienvenue chez Caramba, $nom !</h1>
                <p>Merci de vous être inscrit. Veuillez cliquer sur le lien ci-dessous pour activer votre compte :</p>
                <p><a href='$link'>Confirmer mon email</a></p>
                <p>Si le lien ne fonctionne pas, copiez ceci dans votre navigateur : $link</p>
            ";
            $mail->AltBody = "Bienvenue ! Cliquez ici pour activer votre compte : $link";

            $mail->send();
            return true;
        } catch (Exception $e) {
            // echo "Erreur Mailer: {$mail->ErrorInfo}";
            return false;
        }
    }

    // Nouvelle fonction pour le mot de passe oublié (style identique)
    public static function sendPasswordReset($email, $token) {
        try {
            $mail = self::getConfiguredMailer();
            $mail->addAddress($email); 

            $link = "http://localhost/Caramba/index.php?page=reset&token=" . $token;

            $mail->Subject = 'Réinitialisation de votre mot de passe - Caramba';
            $mail->Body    = "
                <h1>Mot de passe oublié ?</h1>
                <p>Une demande de réinitialisation de mot de passe a été effectuée pour votre compte.</p>
                <p>Cliquez sur le lien ci-dessous pour changer votre mot de passe :</p>
                <p><a href='$link'>Changer mon mot de passe</a></p>
                <p>Ce lien est valide pour une durée limitée.</p>
                <p>Si vous n'êtes pas à l'origine de cette demande, veuillez contacter directement l'assistance.</p>
            ";
            $mail->AltBody = "Cliquez sur ce lien pour réinitialiser votre mot de passe : $link";

            $mail->send();
            return true;
        } catch (Exception $e) {
            // echo "Erreur Mailer: {$mail->ErrorInfo}";
            return false;
        }
    }
}