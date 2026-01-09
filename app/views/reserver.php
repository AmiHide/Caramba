<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver ce trajet</title>
    <link rel="icon" type="png" href="/Caramba/public/img/Caramba-logo.png">
    <link rel="stylesheet" href="/Caramba/public/css/style.css">
    <link rel="stylesheet" href="/Caramba/public/css/responsive.css">
</head>

<body>

<?php include __DIR__ . '/navbar.php'; ?>

<div class="page-container">

    <?php if (!empty($successMessage)): ?>
        <div class="success-popup"><?= htmlspecialchars($successMessage) ?></div>
    <?php endif; ?>

    <h1 style="text-align:center;margin-bottom:40px;font-size:32px;font-weight:800;">Réserver ce trajet</h1>

    <!-- carte trajet -->
    <div class="box">

        <div class="trajet-card-top">
            
            <div class="left-info">

                <a href="index.php?page=voirprofil&id=<?= $trajet['conducteur_id'] ?>" class="driver-link">
                    <img src="uploads/avatars/<?= htmlspecialchars($trajet['conducteur_avatar']) ?>" class="trajet-avatar">
                    <strong><?= htmlspecialchars($prenomConducteur) ?></strong>
                </a>

                <span style="font-size:14px;color:#555;">Heure de départ : <?= substr($trajet['heure_depart'],0,5) ?></span>
            </div>

            <div style="text-align:right;">
                <strong style="font-size:20px;"><?= $trajet['prix'] ?> €</strong><br>
                <span style="color:#777;"><?= $trajet['places_disponibles'] ?> place(s)</span>
            </div>
        </div>

        <p class="trajet-title">
            <?= htmlspecialchars($trajet['depart']) ?> → <?= htmlspecialchars($trajet['arrivee']) ?>
        </p>
    </div>

    <!-- carte 2 -->
    <div class="box">

        <h2 class="section-title">Faites connaissance avec <?= htmlspecialchars($prenomConducteur) ?></h2>

        <p class="bio-text">
            <?= $trajet['description'] ? nl2br(htmlspecialchars($trajet['description'])) : "Aucune description renseignée."; ?>
        </p>

        <hr>

        <h3 class="section-title">À bord du véhicule</h3>

        <p class="prefs-line">
            <!-- Musique -->
            <span>
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="_1rks9rr0 ejccx3ku ejccx3f"><g color="neutralTxtModerate"><g color="currentColor"><path fill="currentColor" fill-rule="evenodd" d="M9 2h12a1 1 0 0 1 1 1v13a3.75 3.75 0 1 1-1.5-3V7h-11v11.25a3.75 3.75 0 1 1-1.5-3V3a1 1 0 0 1 1-1m.5 1.5v2h11v-2zm11 12.5a2.25 2.25 0 1 0-4.5 0 2.25 2.25 0 0 0 4.5 0M5.75 16A2.25 2.25 0 0 1 8 18.249v.001A2.25 2.25 0 1 1 5.75 16" clip-rule="evenodd"></svg>
                Musique : <strong><?= $trajet['musique'] ? "Oui" : "Non" ?></strong>
            </span>

            <!-- Fumeur -->
            <span>
                <svg class="pref-icon cigarette" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path fill="currentColor" fill-rule="evenodd"
                        d="M3.5 16.5v2h14v-2zM3 15a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h16v-5zm17.5 5v-5H22v5zm.75-16v1.25a3.74 3.74 0 0 1-1.471 2.978A4.75 4.75 0 0 1 22 12.25v1.25h-1.5v-1.25A3.25 3.25 0 0 0 17.25 9H17V7.5h.5a2.25 2.25 0 0 0 2.25-2.25V4zm-7.25 2.5a2.25 2.25 0 0 0 0 4.5h2.5a2.5 2.5 0 0 1 2.5 2.5h-1.5a1 1 0 0 0-1-1H14A3.75 3.75 0 1 1 14 5z"/>
                </svg>
                Fumeur : <strong><?= $trajet['fumeur'] ? "Oui" : "Non" ?></strong>
            </span>

    <!-- Animaux -->
    <span>
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="_1rks9rr0 ejccx3ku ejccx3f"><g color="neutralTxtModerate"><g color="currentColor"><path fill="currentColor" fill-rule="evenodd" d="M8.75 4a2.75 2.75 0 1 1 .002 5.5A2.75 2.75 0 0 1 8.75 4M10 6.75a1.25 1.25 0 1 1-2.5 0 1.25 1.25 0 0 1 2.5 0M5.163 9.03A2.754 2.754 0 0 1 7.5 11.75a2.75 2.75 0 1 1-2.337-2.72M6 11.75a1.25 1.25 0 1 1-2.5 0 1.25 1.25 0 0 1 2.5 0M15.25 9.5a2.75 2.75 0 1 1-.002-5.5 2.75 2.75 0 0 1 .002 5.5m0-1.5a1.25 1.25 0 1 1 0-2.5 1.25 1.25 0 0 1 0 2.5M16.687 10.75A2.75 2.75 0 0 1 19.25 9a2.75 2.75 0 1 1-2.563 1.75M19.25 13a1.25 1.25 0 1 1 0-2.5 1.25 1.25 0 0 1 0 2.5M7.182 15.255l2.784-3.897a2.5 2.5 0 0 1 4.069 0l2.783 3.897c1.615 2.261-.446 5.313-3.147 4.66l-.73-.177a4 4 0 0 0-1.882 0l-.73.177c-2.7.654-4.762-2.399-3.147-4.66m1.22.872 2.784-3.897a1 1 0 0 1 1.628 0l2.783 3.897c.808 1.13-.223 2.657-1.573 2.33l-.73-.177a5.5 5.5 0 0 0-2.588 0l-.73.177c-1.35.327-2.38-1.2-1.573-2.33" clip-rule="evenodd"></path></g></g></svg>
        Animaux : <strong><?= $trajet['animaux'] ? "Oui" : "Non" ?></strong>
    </span>
    
        </p>

        <hr>

        <h3 class="section-title">Véhicule</h3>

        <p style="font-size:15px;">
            <span class="vehicle-line">
                <svg class="pref-icon voiture" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path fill="currentColor" fill-rule="evenodd" d="M4.483 8.263A3.75 3.75 0 0 1 7.663 6.5H11.5a3.75 3.75 0 0 1 3 1.5l1.875 2.5H18a4 4 0 0 1 4 4v1a.5.5 0 0 1-.5.5h-1.55a2.5 2.5 0 0 1-4.9 0h-6.1a2.5 2.5 0 0 1-4.9 0H2v-3.5c0-.682.341-1.284.863-1.645zM13.3 8.9l1.2 1.6h-4V8h1a2.25 2.25 0 0 1 1.8.9M9 8v2.5H4.853l.902-1.443A2.25 2.25 0 0 1 7.663 8zm-5.5 4.5A.5.5 0 0 1 4 12h14a2.5 2.5 0 0 1 2.5 2.5h-.708a2.5 2.5 0 0 0-4.584 0H8.792a2.5 2.5 0 0 0-4.584 0H3.5zm3 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2m12-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg>
                <?= htmlspecialchars($trajet['voiture_modele']) ?> - <?= htmlspecialchars($trajet['voiture_couleur']) ?>
            </span>
        </p>

        <?php if (!empty($passagersConfirmes)): ?>
            <hr>
            <h3 class="section-title">Passagers confirmés</h3>

            <?php foreach ($passagersConfirmes as $p): 
                $prenomP = explode(" ", $p['nom']); 
                $prenomP = ucfirst(strtolower($prenomP[0]));
            ?>
                <div class="passenger-mini wide">
                    <img src="uploads/avatars<?= '/' . htmlspecialchars($p['avatar']) ?>">
                    <span><?= htmlspecialchars($prenomP) ?></span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <form method="POST" class="btn-row">
            <a href="index.php?page=recherche" class="btn-back">Retour à la recherche</a>
            <button type="submit" class="btn-confirm">Confirmer la réservation</button>
        </form>

    </div>

</div>

<?php include __DIR__ . '/footer.php'; ?>

<script src="/Caramba/public/js/preventCache.js"></script>

</body>
</html>
