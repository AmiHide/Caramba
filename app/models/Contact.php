<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inclure PHPMailer
require __DIR__ . '/../../PHPMailer-master/src/Exception.php';
require __DIR__ . '/../../PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/../../PHPMailer-master/src/SMTP.php';

class Contact {

    public static function envoyerMail($nom, $email, $message) {
        


        $mail = new PHPMailer(true);

        try {
            // Config SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'caramba.assistance@gmail.com';
            $mail->Password   = 'lvbz oyej jpoq ogoa';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Infos formulaire
            $nom = htmlspecialchars($nom);
            $email = htmlspecialchars($email);
            $message = htmlspecialchars($message);

            // L'email DOIT partir de votre compte Gmail certifié
            $mail->setFrom('caramba.assistance@gmail.com', 'Formulaire Contact');

            // On ajoute l'email du client en "Reply-To" pour pouvoir lui répondre
            $mail->addReplyTo($email, $nom);

            // Destinataire vers le mail Caramba
            $mail->addAddress('caramba.assistance@gmail.com');

            // Objet et contenu du message
            $mail->isHTML(false);
            $mail->Subject = "Nouveau message depuis Caramba";
            $mail->Body    = "Nom : $nom\nEmail : $email\n\nMessage :\n$message";

            $mail->send();
            return true;

        } catch (Exception $e) {
            return false;
        }
    }
}