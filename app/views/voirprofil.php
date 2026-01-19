<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil public - Caramba</title>
    <link rel="icon" type="png" href="/Caramba/public/img/Caramba-logo.png">
    <link rel="stylesheet" href="/caramba/public/css/style.css">
    <link rel="stylesheet" href="/Caramba/public/css/responsive.css">
</head>

<body>

<?php include __DIR__ . '/navbar.php'; ?>


<main class="account-container public-profile">

    <h1>Profil public</h1>

    <!-- en-tête profil -->
    <section class="account-card account-header-card">
        <div class="account-avatar-block">
            <img class="account-avatar" 
                 src="/caramba/public/<?= htmlspecialchars($profil['avatar'] ? 'uploads/avatars/'.$profil['avatar'] : 'img/user-icon.png'); ?>" 
                 alt="Avatar">
        </div>

        <div class="account-header-info" style="flex:1; position:relative;">

            <!-- nom et age -->
            <h2 style="margin-bottom:4px; font-size:26px; font-weight:600;">
                <span style="text-transform:capitalize;">
                    <?= htmlspecialchars($prenom); ?>
                </span>

                <?php if ($age !== null): ?>
                    <span style="font-size:18px; font-weight:400; color:#444; text-transform:none;">
                        (<?= $age ?> ans)
                    </span>
                <?php endif; ?>
            </h2>

            <div class="profile-rating" style="margin-top:6px;">
                <?php if ($note_moyenne !== null): ?>
                    <span class="profile-rating-star star">★</span>
                    <span class="profile-rating-text">
                        <?= $note_moyenne; ?>/5
                        <span class="profile-rating-sub">
                            (basé sur <?= $total_avis; ?> avis)
                        </span>
                    </span>
                <?php else: ?>
                    <span class="profile-rating-text">Aucun avis pour le moment.</span>
                <?php endif; ?>
            </div>

            <!-- badges -->
            <div class="account-status" style="margin-top:12px;">
                <?php if (!empty($profil['is_superdriver']) && $profil['is_superdriver']): ?>
                <span class="badge badge-superdriver"
                    style="display:inline-flex; align-items:center; gap:6px;">
                    
                    <svg viewBox="0 0 24 24" width="16" height="16"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <g>
                            <path fill="#fff" fill-rule="evenodd"
                                d="M3 0a2 2 0 0 0-1.518 3.302l5.526 6.447a8 8 0 1 0 9.985 0l5.526-6.447A2 2 0 0 0 21 0h-6a2 2 0 0 0-1.518.698L12 2.427 10.518.698A2 2 0 0 0 9 0z"
                                clip-rule="evenodd"></path>
                            <path fill="#E6C1C1" d="M18 16a6 6 0 1 1-12 0 6 6 0 0 1 12 0"></path>
                            <path fill="#CCAAAE" d="M3 2h6l6 7H9z"></path>
                            <path fill="#F5E0E4" d="M21 2h-6L9 9h6z"></path>
                        </g>
                    </svg>

                    Super Driver
                </span>
            <?php endif; ?>

                <?php if (!empty($profil['preuve_identite'])): ?>
                    <span class="badge badge-success"
                          style="display:inline-flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="16" height="16">
                          <path fill="#046A38" fill-rule="evenodd"
                            d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10m5.53-12.72a.75.75 0 0 0-1.06-1.06l-5.97 5.97-2.97-2.97a.75.75 0 1 0-1.06 1.06l3.5 3.5a.75.75 0 0 0 1.06 0z"/>
                        </svg>
                        Identité vérifiée
                    </span>
                <?php endif; ?>

                <?php if ((int)$profil['conducteur_valide'] === 1): ?>
                    <span class="badge badge-info"
                          style="display:inline-flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="16" height="16">
                          <path fill="#1E5AA8" fill-rule="evenodd"
                            d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10m5.53-12.72a.75.75 0 0 0-1.06-1.06l-5.97 5.97-2.97-2.97a.75.75 0 1 0-1.06 1.06l3.5 3.5a.75.75 0 0 0 1.06 0z"/>
                        </svg>
                        Permis vérifié
                    </span>
                <?php endif; ?>

            </div>

            <p style="
                position:absolute;
                bottom:-25px;
                right:0;
                margin:0;
                font-size:14px;
                color:#777;
            ">
                <?= htmlspecialchars($texte_membre_depuis); ?>
            </p>

        </div>
    </section>

    <!-- description + préférences + voiture -->
    <section class="account-card">
        <h2>À propos de <?= htmlspecialchars($prenom); ?></h2>

        <?php if (!empty($profil['description'])): ?>
            <p style="margin-top:8px; margin-bottom:18px; line-height:1.5;">
                <?= nl2br(htmlspecialchars($profil['description'])); ?>
            </p>
        <?php else: ?>
            <p style="margin-top:8px; margin-bottom:18px; color:#777;">
                Aucun texte de présentation ajouté pour le moment.
            </p>
        <?php endif; ?>

        <!-- infos conducteur -->
        <?php if ($profil['role'] === 'conducteur'): ?>
            <hr class="account-separator">
            <h3>Infos conducteur</h3>

            <?php if (!empty($profil['voiture_modele']) || !empty($profil['voiture_couleur'])): ?>

                <span class="vehicle-line">
                    <svg class="pref-icon voiture" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path fill="currentColor" fill-rule="evenodd" d="M4.483 8.263A3.75 3.75 0 0 1 7.663 6.5H11.5a3.75 3.75 0 0 1 3 1.5l1.875 2.5H18a4 4 0 0 1 4 4v1a.5.5 0 0 1-.5.5h-1.55a2.5 2.5 0 0 1-4.9 0h-6.1a2.5 2.5 0 0 1-4.9 0H2v-3.5c0-.682.341-1.284.863-1.645zM13.3 8.9l1.2 1.6h-4V8h1a2.25 2.25 0 0 1 1.8.9M9 8v2.5H4.853l.902-1.443A2.25 2.25 0 0 1 7.663 8zm-5.5 4.5A.5.5 0 0 1 4 12h14a2.5 2.5 0 0 1 2.5 2.5h-.708a2.5 2.5 0 0 0-4.584 0H8.792a2.5 2.5 0 0 0-4.584 0H3.5zm3 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2m12-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg>
                    <?= htmlspecialchars(trim($profil['voiture_modele'].' - '.$profil['voiture_couleur'], ' -')); ?>
                </span>

            <?php else: ?>
                <p style="margin:6px 0 0;">Aucune information sur la voiture.</p>
            <?php endif; ?>
        <?php endif; ?>

        <!-- préférences -->
        <hr class="account-separator">

        <h3>Préférences</h3>

        <div class="prefs-grid-pro">

        <!-- Musique -->
        <div class="pref-card">
            <div class="pref-icon-wrap <?= $profil['musique'] ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="_1rks9rr0 ejccx3ku ejccx3f"><g color="neutralTxtModerate"><g color="currentColor"><path fill="currentColor" fill-rule="evenodd" d="M9 2h12a1 1 0 0 1 1 1v13a3.75 3.75 0 1 1-1.5-3V7h-11v11.25a3.75 3.75 0 1 1-1.5-3V3a1 1 0 0 1 1-1m.5 1.5v2h11v-2zm11 12.5a2.25 2.25 0 1 0-4.5 0 2.25 2.25 0 0 0 4.5 0M5.75 16A2.25 2.25 0 0 1 8 18.249v.001A2.25 2.25 0 1 1 5.75 16" clip-rule="evenodd"></svg>
            </div>
            <div class="pref-info">
                <span class="pref-label">Musique</span>
                <span class="pref-status <?= $profil['musique'] ? 'yes' : 'no' ?>">
                    <?= $profil['musique'] ? 'Accepte' : "N'accepte pas"; ?>
                </span>
            </div>
        </div>

        <!-- Fumeur -->
        <div class="pref-card">
            <div class="pref-icon-wrap <?= $profil['fumeur'] ? 'active' : '' ?>">
                <svg class="pref-icon cigarette" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path fill="currentColor" fill-rule="evenodd"
                        d="M3.5 16.5v2h14v-2zM3 15a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h16v-5zm17.5 5v-5H22v5zm.75-16v1.25a3.74 3.74 0 0 1-1.471 2.978A4.75 4.75 0 0 1 22 12.25v1.25h-1.5v-1.25A3.25 3.25 0 0 0 17.25 9H17V7.5h.5a2.25 2.25 0 0 0 2.25-2.25V4zm-7.25 2.5a2.25 2.25 0 0 0 0 4.5h2.5a2.5 2.5 0 0 1 2.5 2.5h-1.5a1 1 0 0 0-1-1H14A3.75 3.75 0 1 1 14 5z"/>
                </svg>
            </div>
            <div class="pref-info">
                <span class="pref-label">Fumeur</span>
                <span class="pref-status <?= $profil['fumeur'] ? 'yes' : 'no' ?>">
                    <?= $profil['fumeur'] ? 'Accepte' : "N'accepte pas"; ?>
                </span>
            </div>
        </div>

        <!-- Animaux -->
        <div class="pref-card">
            <div class="pref-icon-wrap <?= $profil['animaux'] ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="_1rks9rr0 ejccx3ku ejccx3f"><g color="neutralTxtModerate"><g color="currentColor"><path fill="currentColor" fill-rule="evenodd" d="M8.75 4a2.75 2.75 0 1 1 .002 5.5A2.75 2.75 0 0 1 8.75 4M10 6.75a1.25 1.25 0 1 1-2.5 0 1.25 1.25 0 0 1 2.5 0M5.163 9.03A2.754 2.754 0 0 1 7.5 11.75a2.75 2.75 0 1 1-2.337-2.72M6 11.75a1.25 1.25 0 1 1-2.5 0 1.25 1.25 0 0 1 2.5 0M15.25 9.5a2.75 2.75 0 1 1-.002-5.5 2.75 2.75 0 0 1 .002 5.5m0-1.5a1.25 1.25 0 1 1 0-2.5 1.25 1.25 0 0 1 0 2.5M16.687 10.75A2.75 2.75 0 0 1 19.25 9a2.75 2.75 0 1 1-2.563 1.75M19.25 13a1.25 1.25 0 1 1 0-2.5 1.25 1.25 0 0 1 0 2.5M7.182 15.255l2.784-3.897a2.5 2.5 0 0 1 4.069 0l2.783 3.897c1.615 2.261-.446 5.313-3.147 4.66l-.73-.177a4 4 0 0 0-1.882 0l-.73.177c-2.7.654-4.762-2.399-3.147-4.66m1.22.872 2.784-3.897a1 1 0 0 1 1.628 0l2.783 3.897c.808 1.13-.223 2.657-1.573 2.33l-.73-.177a5.5 5.5 0 0 0-2.588 0l-.73.177c-1.35.327-2.38-1.2-1.573-2.33" clip-rule="evenodd"></path></g></g></svg>
            </div>
            <div class="pref-info">
                <span class="pref-label">Animaux</span>
                <span class="pref-status <?= $profil['animaux'] ? 'yes' : 'no' ?>">
                    <?= $profil['animaux'] ? 'Accepte' : "N'accepte pas"; ?>
                </span>
            </div>
        </div>

    </div>
    </section>


<!-- historique rapide -->
<section class="account-card">
    <div class="account-header-row">
        <h2 style="margin:0 0 20px 0;">Historique rapide</h2>
    </div>

    <?php if (empty($history)): ?>
        <p style="color:#777; margin-top: 4px;">Aucun trajet enregistré.</p>
    <?php else: ?>
        <div class="history-grid" style="margin-top:15px;">
            <?php foreach ($history as $h): 
                $isFuture = $h['future'];
                $cardClass = $isFuture ? 'history-card-future' : 'history-card-past';
                $roleLabel = $h['role'] === 'conducteur' ? "En tant que conducteur" : "En tant que passager";
            ?>
                <div class="history-card <?= $cardClass ?>">
                    <div class="history-title">
                        <?= htmlspecialchars($h['depart']) ?> → <?= htmlspecialchars($h['arrivee']) ?>
                    </div>

                    <div class="history-price">
                        <?= htmlspecialchars($h['prix']) ?> €
                    </div>

                    <div class="history-role">
                        <?= $roleLabel ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <p style="margin-top:18px; font-size:14px; color:#444;">
            <strong><?= $total_trajets ?></strong> trajets publiés et complétés
        </p>

    <?php endif; ?>
</section>

    <!-- Avis reçus -->
    <section class="account-card">
        <div class="account-header-row">
            <h2 style="margin:0;">Avis reçus</h2>
            <?php if ($total_avis > 0): ?>
                <span style="font-size:14px; color:#555;">
                    <?= $total_avis; ?> avis
                </span>
            <?php endif; ?>
        </div>

        <?php if ($total_avis === 0): ?>
            <p style="color:#777; margin-top:4px;">Cet utilisateur n’a pas encore reçu d’avis.</p>
        <?php else: ?>
            <div class="reviews-list">
                <?php foreach ($avis_liste as $avis): ?>
                    <article class="review-card">
                        <div class="review-header">
                            <div class="review-avatar">
                                <img src="/caramba/public/<?= htmlspecialchars($avis['auteur_avatar'] ? 'uploads/avatars/'.$avis['auteur_avatar'] : 'img/user-icon.png'); ?>"
                                     alt="Avatar auteur">
                            </div>
                            <div class="review-meta">
                                <?php
                                $parts = explode(' ', trim($avis['auteur_nom']));
                                $prenomAvis = ucfirst(strtolower($parts[0]));
                                ?>
                                <strong><?= htmlspecialchars($prenomAvis); ?></strong>
                                <div class="review-sub">
                                    Trajet <?= htmlspecialchars($avis['ville_depart']); ?> → <?= htmlspecialchars($avis['ville_arrivee']); ?>
                                    • <?= date_mois_court_fr($avis['date_avis']); ?>
                                </div>
                                <div class="review-note">
                                    <span class="review-note-star star">★</span>
                                    <?= (int)$avis['note']; ?>/5
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($avis['commentaire'])): ?>
                            <p class="review-comment">
                                <?= nl2br(htmlspecialchars($avis['commentaire'])); ?>
                            </p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

</main>

<?php include __DIR__ . '/footer.php'; ?>

<script src="/Caramba/public/js/preventCache.js"></script>
</body>
</html>