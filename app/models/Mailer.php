<?php
// Caramba/app/models/Mailer.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Ajustez les chemins si nécessaire selon votre structure
require_once __DIR__ . '/../../PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../../PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../../PHPMailer-master/src/SMTP.php';

class Mailer {
    public static function sendVerification($email, $nom, $token) {
        $mail = new PHPMailer(true);

        try {
            // Configuration SMTP (Reprise de votre fichier Contact.php)
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'caramba.assistance@gmail.com'; // Votre email
            $mail->Password   = 'lvbz oyej jpoq ogoa'; // Mettez ici le mot de passe d'application (comme dans Contact.php)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Expéditeur et Destinataire
            $mail->setFrom('caramba.assistance@gmail.com', 'Caramba');
            $mail->addAddress($email, $nom);

            // Lien de vérification
            // Adaptez "localhost/Caramba" selon votre URL réelle
            $link = "http://localhost/Caramba/index.php?page=verify_email&token=" . $token;

            // Contenu
            $mail->isHTML(true);
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
            // Pour le debug, vous pouvez décommenter la ligne suivante :
            // echo "Erreur Mailer: {$mail->ErrorInfo}";
            return false;
        }
    }
}