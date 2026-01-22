<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CGU & Mentions légales - Caramba</title>
    <link rel="icon" type="png" href="/Caramba/public/img/Caramba-logo.png">
    <link rel="stylesheet" href="/Caramba/public/css/style.css">
    <link rel="stylesheet" href="/Caramba/public/css/responsive.css">
</head>

<body>

<?php include __DIR__ . '/navbar.php'; ?>

<main class="legal-container">

    <!-- CGU -->
    <section class="legal-section">
        <h2>Conditions d'utilisation de Caramba</h2>

        <?php foreach ($cguSections as $cgu): ?>
            <div class="legal-column">
                <h3><?= htmlspecialchars($cgu['titre']) ?></h3>
                <p><?= nl2br(htmlspecialchars($cgu['contenu'])) ?></p>
            </div>
        <?php endforeach; ?>
        
        <?php $lastUpdate = LegalPage::getLastUpdate('cgu'); ?>
<p class="legal-update-date">
    <strong>Dernière mise à jour :</strong> 
    <?= date("d/m/Y", strtotime($lastUpdate)) ?>
</p>
    </section>

    <!-- Mentions légales -->
    <section class="legal-section">
        <h2>Mentions légales</h2>

        <?php foreach ($mentionSections as $m): ?>
            <div class="legal-column">
                <h3><?= htmlspecialchars($m['titre']) ?></h3>
                <p><?= nl2br(htmlspecialchars($m['contenu'])) ?></p>
            </div>
        <?php endforeach; ?>

        <?php $lastUpdate = LegalPage::getLastUpdate('mentions'); ?>
<p class="legal-update-date">
    <strong>Dernière mise à jour :</strong> 
    <?= date("d/m/Y", strtotime($lastUpdate)) ?>
</p>
    </section>

</main>

<?php include __DIR__ . '/footer.php'; ?>
<script src="/Caramba/public/js/preventCache.js"></script>

</body>
</html>
