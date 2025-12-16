<?php

class VoirProfilController
{
    public function index()
    {
        if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
            header("Location: index.php?page=home");
            exit;
        }

        $id = (int) $_GET['id'];

        // Profil
        $profil = User::getPublicProfile($id);
        if (!$profil) {
            echo "Profil introuvable.";
            exit;
        }

        $parts = explode(' ', trim($profil['nom']));
        $prenom = ucfirst(strtolower($parts[0]));

        $age = null;
        if (!empty($profil['date_naissance'])) {
            $birth = new DateTime($profil['date_naissance']);
            $age = (new DateTime())->diff($birth)->y;
        }

        $mois_fr = [
            '01'=>'janvier','02'=>'février','03'=>'mars','04'=>'avril','05'=>'mai','06'=>'juin',
            '07'=>'juillet','08'=>'août','09'=>'septembre','10'=>'octobre','11'=>'novembre','12'=>'décembre',
        ];
        $ins = new DateTime($profil['date_inscription']);
        $texte_membre_depuis = "Membre depuis " . $mois_fr[$ins->format('m')] . " " . $ins->format('Y');

        // Historique rapide
        $history = Trajet::getPublicHistory($id);
        $total_trajets = Trajet::countTrajetsConducteur($id);

        // Stats avis
        $rating = Avis::getStats($id);
        $note_moyenne = $rating['moyenne'] ? number_format($rating['moyenne'], 1, ',', '') : null;
        $total_avis = (int)$rating['total'];

        // Liste avis
        $avis_liste = Avis::getList($id);

        $profil['is_superdriver'] = User::isSuperDriver($profil['id']);

        require __DIR__ . "/../views/voirprofil.php";
    }
}
