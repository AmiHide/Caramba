<?php

class LegalController
{
    public function index()
    {
        // Récupérer les sections dynamiquement
        $cguSections = LegalPage::getBySection('cgu');
        $mentionSections = LegalPage::getBySection('mentions');
// Nouvelle variable pour la date la plus récente
$lastUpdateCGU = LegalPage::getLastUpdate('cgu');
$lastUpdateMentions = LegalPage::getLastUpdate('mentions');

        // Charger la vue publique
        require __DIR__ . '/../views/cgu_mentions.php';
    }
}
