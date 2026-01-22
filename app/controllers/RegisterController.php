<?php

class RegisterController
{
    public function index()
    {
        $error = "";
        $success = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $error = "";
            $success = "";

            // Récup des champs du formulaire
            $prenom    = trim($_POST["prenom"] ?? "");
            $nom       = trim($_POST["nom"] ?? "");
            $sexe      = $_POST["sexe"] ?? null;
            $naissance = $_POST["naissance"] ?? null;
            $tel       = trim($_POST["tel"] ?? "");
            $region    = $_POST["region"] ?? "";
            $pseudo    = trim($_POST["username"] ?? "");
            $email     = trim($_POST["email"] ?? "");
            $pwd       = $_POST["password"] ?? "";
            $pwd2      = $_POST["password2"] ?? "";
            $conducteurChoix = $_POST["conducteur"] ?? "Non";

            // Vérifs de base
            if (!$naissance) {
                $error = "Veuillez renseigner votre date de naissance.";
            } else {
                $today    = new DateTime();
                $birthday = new DateTime($naissance);
                $age      = $today->diff($birthday)->y;

                if ($age < 18) {
                    $error = "⚠ Vous devez avoir au minimum 18 ans pour vous inscrire.";
                } elseif ($pwd !== $pwd2) {
                    $error = "Les mots de passe ne correspondent pas.";
                } elseif (!isset($_POST["cgu"])) {
                    $error = "Vous devez accepter les conditions générales d'utilisation.";
                }
            }

            // Vérif email / pseudo déjà existants
            if ($error === "" && User::existsByEmailOrPseudo($email, $pseudo)) {
                $error = "⚠ Cet email ou ce pseudo est déjà utilisé.";
            }

            // Vérif la date de naissance (Si elle est au dessus de 18 ans et en dessous de 100 ans)
            $birthDate = new DateTime($_POST['naissance']);
            $maxDate = (new DateTime())->modify('-18 years');
            $minDate = (new DateTime())->modify('-100 years');

            if ($birthDate > $maxDate || $birthDate < $minDate) {
                $error = "La date de naissance doit être comprise entre {$maxDate} et {$minDate}.";
            }


            
            if ($error === "") {

                // Dossiers d'upload 
                $uploadIdDirFs     = __DIR__ . '/../../public/uploads/identite/';
                $uploadPermisDirFs = __DIR__ . '/../../public/uploads/permis/';

                $uploadIdRel     = '/Caramba/public/uploads/identite/';
                $uploadPermisRel = '/Caramba/public/uploads/permis/';

                // Preuve d'identité 
                $preuvePath = null;

                if (isset($_FILES["idfile"]) && $_FILES["idfile"]["error"] === UPLOAD_ERR_OK) {
                    $ext = pathinfo($_FILES["idfile"]["name"], PATHINFO_EXTENSION);
                    $idFileName = "id_" . uniqid() . "." . $ext;
                    move_uploaded_file($_FILES["idfile"]["tmp_name"], $uploadIdDirFs . $idFileName);
                    $preuvePath = $uploadIdRel . $idFileName;
                } else {
                    $error = "⚠️ Vous devez fournir une preuve d'identité.";
                }

                // Permis (si conducteur)
                $permisPath = null;
                $conducteur_demande = 0;

                if ($error === "" && $conducteurChoix === "Oui") {
                $conducteur_demande = 1;

                if (!isset($_FILES["driverfile"]) || $_FILES["driverfile"]["error"] !== UPLOAD_ERR_OK) {
                    $error = "⚠️ Vous devez obligatoirement fournir une photo de votre permis pour devenir conducteur.";
                } else {
                    $ext2 = strtolower(pathinfo($_FILES["driverfile"]["name"], PATHINFO_EXTENSION));
                    $permFileName = "permis_" . uniqid() . "." . $ext2;

                  
                    if (!is_dir($uploadPermisDirFs)) {
                        mkdir($uploadPermisDirFs, 0777, true);
                    }

                    // upload du fichier
                    if (move_uploaded_file($_FILES["driverfile"]["tmp_name"], $uploadPermisDirFs . $permFileName)) {
                        
                        $permisPath = $uploadPermisRel . $permFileName;
                    } else {
                        $error = "Erreur lors du téléchargement du permis.";
                    }
                }
            }

                if ($error === "") {
                    $data = [
                        'nom_complet'        => $prenom . " " . $nom,
                        'email'              => $email,
                        'password_hash'      => password_hash($pwd, PASSWORD_BCRYPT),
                        'date_inscription'   => date("Y-m-d H:i:s"),
                        'avatar'             => "user-icon.png",
                        'sexe'               => $sexe,
                        'naissance'          => $naissance,
                        'tel'                => $tel,
                        'region'             => $region,
                        'preuve_identite'    => $preuvePath,
                        'permis'             => $permisPath,
                        'pseudo'             => $pseudo,
                        'conducteur_demande' => $conducteur_demande,
                        'conducteur_valide'  => 0,
                        'role'               => "passager"
                    ];

                    User::insertFromRegister($data);

                    if ($conducteur_demande == 1) {
                        $_SESSION["register_success"] = "Votre compte a été créé avec succès !
                            Votre demande de rôle conducteur sera vérifiée par un administrateur.";
                    } else {
                        $_SESSION["register_success"] = "Votre compte a été créé avec succès ! Bienvenue chez Caramba.";
                    }

                    header("Location: index.php?page=register");
                    exit;
                }
            }

        }

        if (isset($_SESSION["register_success"])) {
            $success = $_SESSION["register_success"];
            unset($_SESSION["register_success"]);
        }

        require __DIR__ . '/../views/register.php';
    }
}
