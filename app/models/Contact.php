<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inclure PHPMailer
require __DIR__ . '/../../PHPMailer-master/src/Exception.php';
require __DIR__ . '/../../PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/../../PHPMailer-master/src/SMTP.php';

class Contact {

    
        public static function envoyerMail($nom, $emailClient, $message) {
        
        // 1. Chargement de la config .env
        $envFile = __DIR__ . '/../../.env';
        if (file_exists($envFile)) {
            $env = parse_ini_file($envFile);
        } else {
            return "Erreur technique : Configuration introuvable.";
        }

        $mail = new PHPMailer(true);

        try {
            // 2. Config SMTP
            $mail->CharSet = 'UTF-8'; // Important pour les accents
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $env['email'];
            $mail->Password   = $env['password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // 3. Expéditeur et Destinataire
            $mail->setFrom($env['email'], 'Caramba Contact');
            $mail->addAddress($env['email']); // Vous recevez le mail
            $mail->addReplyTo($emailClient, $nom); // Pour répondre au client

            // 4. Nettoyage pour le HTML
            $nomSafe = htmlspecialchars($nom);
            $emailSafe = htmlspecialchars($emailClient);
            $messageSafe = htmlspecialchars($message);

            // 5. Contenu HTML (C'est ici qu'on règle le problème d'apostrophes)
            $mail->isHTML(true); 
            $mail->Subject = "Nouveau message depuis Caramba";
            
            $mail->Body = "
                <h2>Nouveau message de contact</h2>
                <p><strong>Nom :</strong> $nomSafe</p>
                <p><strong>Email :</strong> $emailSafe</p>
                <hr>
                <p><strong>Message :</strong><br>" . nl2br($messageSafe) . "</p>
            ";

            // 6. Version Texte brut (Pour les boites mail sans HTML)
            // On reprend les variables d'origine ($nom, $message) qui n'ont pas été modifiées par htmlspecialchars
            // ou on utilise strip_tags si on veut être sûr.
            $mail->AltBody = "Nom : $nom\nEmail : $emailClient\n\nMessage :\n$message";

            $mail->send();
            return true;

        } catch (Exception $e) {
            return "Erreur Mailer: " . $mail->ErrorInfo;
        }
    }
}