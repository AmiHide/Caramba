<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte - Caramba</title>
    <link rel="icon" type="png" href="/Caramba/public/img/Caramba-logo.png">
    <link rel="stylesheet" href="/Caramba/public/css/style.css">
    <link rel="stylesheet" href="/Caramba/public/css/responsive.css">
</head>

<body>

<?php include __DIR__ . '/navbar.php'; ?>

<main class="account-container">

<?php if (!empty($isAdminView) && $isAdminView): ?>
    <div class="admin-banner">
        <strong>Mode administrateur</strong> vous consultez le profil de 
        <span style="color:#e67e22;"><?= htmlspecialchars($user['nom']) ?></span>
    </div>
<?php else: ?>
    <h1>Mon compte</h1>
<?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="flash-success flash-msg">
            <?= htmlspecialchars($success); ?>
            <span class="close-flash">&times;</span>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="flash-error flash-msg">
            <?= htmlspecialchars($error); ?>
            <span class="close-flash">&times;</span>
        </div>
    <?php endif; ?>


    <!-- box avatar et info perso -->
    <section class="account-card account-header-card">

        <div class="account-avatar-block">
            <img src="/Caramba/public/uploads/avatars/<?= htmlspecialchars($user['avatar']) ?>"
                 alt="Avatar" class="account-avatar">

            <form method="post" enctype="multipart/form-data" class="avatar-form">
                <input type="hidden" name="action" value="update_avatar">
                <label class="btn-outline">
                    Changer ma photo
                    <input type="file" name="avatar" accept="image/*"
                           onchange="this.form.submit()" hidden>
                </label>
            </form>
        </div>

        <div class="account-header-info">

            <?php
            $parts = explode(' ', trim($user['nom']));
            $prenom = ucfirst(strtolower($parts[0]));
            $nomComplet = strtoupper(implode(' ', array_slice($parts, 1)));
            $affichageNom = $prenom . ' ' . $nomComplet;
            ?>

            <h2><?= htmlspecialchars($affichageNom) ?></h2>
            <p><?= htmlspecialchars($user['email']) ?></p>

            <p class="account-date-inscription">
                Inscrit depuis le <?= date('d/m/Y', strtotime($user['date_inscription'])) ?>
            </p>

            <div class="account-badges-top">

                <!-- rôle conducteur -->
                <?php if ($user['conducteur_valide']): ?>
                    <span class="badge badge-success">Conducteur validé</span>
                <?php elseif ($user['conducteur_demande']): ?>
                    <span class="badge badge-warning">Demande conducteur en cours</span>
                <?php else: ?>
                    <span class="badge badge-neutral">Passager</span>
                <?php endif; ?>

                <!-- NUMÉRO -->
                <!-- <?php if ($user['numero_verifie']): ?>
                    <span class="badge badge-success">Numéro vérifié</span>
                <?php else: ?>
                    <span class="badge badge-warning">Numéro non vérifié</span>
                <?php endif; ?> -->

                <!-- permis -->
                <?php if (empty($user['permis'])): ?>
                    <span class="badge badge-warning">Permis non fourni</span>
                <?php endif; ?>

                <!-- expiration permis -->
                <?php if (!empty($user['permis_upload_at'])): ?>
                    <?php
                    $upload = new DateTime($user['permis_upload_at']);
                    $now   = new DateTime();
                    $days  = $upload->diff($now)->days;
                    ?>

                    <?php if ($user['conducteur_valide'] && $days <= 7): ?>
                        <span class="badge badge-info">
                            Validation conducteur : <?= 7 - $days ?> jour(s) restant(s)
                        </span>
                    <?php endif; ?>

                    <?php if (!$user['conducteur_valide'] && $days > 7): ?>
                        <span class="badge badge-warning">
                            Validation expirée - renvoyez votre permis
                        </span>
                    <?php endif; ?>
                <?php endif; ?>

            </div>

            <a href="index.php?page=voirprofil&id=<?= $user['id'] ?>" class="view-public-link">
                Voir mon profil public
            </a>

        </div>
    </section>



    <!-- vérif num(marche avec vonage seulement 1 numéro) 
    <section class="account-card verify-phone-card">

        <?php if (!$user['numero_verifie']): ?>
            <div class="verify-phone-warning">
                <h3>Vérification du numéro</h3>

                <p class="verify-desc">
                    Pour sécuriser votre compte, votre numéro doit être vérifié.
                </p>

                <a href="index.php?page=verifnum" class="btn-verify-phone">
                    Vérifier mon numéro
                </a>
            </div>
        <?php endif; ?>

    </section> -->



    <!-- bloc info : préférence, modèle voiture etc ... -->
    <section class="account-card">
        <h2>Informations personnelles</h2>

        <hr class="account-separator">

        <form method="post" class="account-form">
            <input type="hidden" name="action" value="update_infos">

            <h3>Description</h3>
            <p style="font-size: 13px; color:#666; margin-top:-6px;">
                Écrivez quelques lignes sur vous. (minimum 20 mots)
            </p>

            <div class="field">
                <textarea name="description" rows="4" class="textarea-field"
                ><?= htmlspecialchars($user['description']) ?></textarea>
            </div>


            <div class="account-grid">

                <div class="field">
                    <label>Nom</label>
                    <input type="text" value="<?= htmlspecialchars($user['nom']) ?>" disabled>
                </div>

                <div class="field">
                    <label>Email</label>
                    <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                </div>

                <div class="field">
                    <label>Date de naissance</label>
                    <input type="text" value="<?= htmlspecialchars($user['date_naissance']) ?>" disabled>
                </div>

                <div class="field">
                    <label>Sexe</label>
                    <input type="text" value="<?= htmlspecialchars($user['sexe']) ?>" disabled>
                </div>

                <div class="field">
                    <label>Téléphone</label>
                    <input type="text" name="telephone" value="<?= htmlspecialchars($user['telephone']) ?>">
                </div>

                <div class="field">
                    <label>Région</label>
                    <select name="region">
                        <?php foreach ($regions as $reg): ?>
                            <option value="<?= htmlspecialchars($reg) ?>"
                                <?= $user['region'] === $reg ? "selected" : "" ?>>
                                <?= htmlspecialchars($reg) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>


            <!-- infos conducteur si actif -->
            <?php if ($user['role']==='conducteur' || $user['conducteur_demande'] || $user['conducteur_valide']): ?>

                <hr class="account-separator">
                <h3>Infos conducteur</h3>

                <div class="account-grid account-grid-conducteur">
                    <div class="field">
                        <label>Modèle de voiture</label>
                        <input type="text" name="voiture_modele"
                               value="<?= htmlspecialchars($user['voiture_modele']) ?>"
                               placeholder="Peugeot 208">
                    </div>

                    <div class="field">
                        <label>Couleur de la voiture</label>
                        <input type="text" name="voiture_couleur"
                               value="<?= htmlspecialchars($user['voiture_couleur']) ?>"
                               placeholder="Blanc">
                    </div>
                </div>

            <?php endif; ?>


            <hr class="account-separator">
            <h3>Préférences</h3>

            <div class="prefs-grid">

                <!-- musique -->
                <div class="pref-group">
                    <span>Musique</span>
                    <div class="pref-buttons">
                        <label class="pref-btn <?= $musiqueOn ? 'active':'' ?>">
                            <input type="radio" name="musique" value="1" <?= $musiqueOn?'checked':'' ?>>
                            Accepte
                        </label>

                        <label class="pref-btn <?= !$musiqueOn ? 'active':'' ?>">
                            <input type="radio" name="musique" value="0" <?= !$musiqueOn?'checked':'' ?>>
                            N'accepte pas
                        </label>
                    </div>
                </div>

                <!-- fumeur -->
                <div class="pref-group">
                    <span>Fumeur</span>
                    <div class="pref-buttons">
                        <label class="pref-btn <?= $fumeurOn ? 'active':'' ?>">
                            <input type="radio" name="fumeur" value="1" <?= $fumeurOn?'checked':'' ?>>
                            Accepte
                        </label>

                        <label class="pref-btn <?= !$fumeurOn ? 'active':'' ?>">
                            <input type="radio" name="fumeur" value="0" <?= !$fumeurOn?'checked':'' ?>>
                            N'accepte pas
                        </label>
                    </div>
                </div>

                <!-- animaux -->
                <div class="pref-group">
                    <span>Animaux</span>
                    <div class="pref-buttons">
                        <label class="pref-btn <?= $animauxOn ? 'active':'' ?>">
                            <input type="radio" name="animaux" value="1" <?= $animauxOn?'checked':'' ?>>
                            Accepte
                        </label>

                        <label class="pref-btn <?= !$animauxOn ? 'active':'' ?>">
                            <input type="radio" name="animaux" value="0" <?= !$animauxOn?'checked':'' ?>>
                            N'accepte pas
                        </label>
                    </div>
                </div>

            </div>

            <div class="account-actions">
                <button type="submit" class="btn-primary">
                    Enregistrer les modifications
                </button>
            </div>

        </form>
    </section>



    <!-- doc uploads (identité et permis) -->
    <section class="account-card">
        <h2>Documents</h2>
        <hr class="account-separator">

        <div class="documents-grid">

            <!-- identité -->
            <div class="doc-item">
                <div class="doc-header"><h3>Pièce d'identité</h3></div>

                <div class="doc-body">

                    <?php if (!empty($user['preuve_identite'])): ?>
                        <div class="doc-status doc-valid">Déjà envoyée</div>

                        <a href="<?= htmlspecialchars($user['preuve_identite']) ?>"
                           class="doc-view" target="_blank">
                            Voir le document
                        </a>

                    <?php else: ?>

                        <div class="doc-status doc-missing">⚠ Document non fourni</div>

                        <form method="post" enctype="multipart/form-data" class="doc-upload-form">
                            <input type="hidden" name="action" value="upload_identite">
                            <label class="doc-upload-btn">
                                Envoyer ma pièce d'identité
                                <input type="file" name="identite" accept="image/*,application/pdf"
                                       onchange="this.form.submit()" hidden>
                            </label>
                        </form>

                    <?php endif; ?>

                </div>
            </div>


            <!-- permis -->
            <div class="doc-item">

                <div class="doc-header"><h3>Permis de conduire</h3></div>

                <div class="doc-body">

                    <?php
                    $canReupload = !$user['conducteur_valide'];
                    ?>

                    <?php if (!empty($user['permis'])): ?>

                        <div class="doc-status <?= $canReupload ? 'doc-missing' : 'doc-valid' ?>">
                            <?= $canReupload ? "⚠ Permis expiré ou refusé" : "Permis envoyé" ?>
                        </div>

                        <a href="<?= htmlspecialchars($user['permis']) ?>" class="doc-view" target="_blank">

                            Voir le permis
                        </a>


                        <?php if ($user['conducteur_demande'] && !$user['conducteur_valide']): ?>
                            <p class="doc-waiting">En attente de validation admin</p>
                        <?php endif; ?>

                        <?php if ($canReupload && !$user['conducteur_demande']): ?>
                            <form method="post" enctype="multipart/form-data" class="doc-upload-form">
                                <input type="hidden" name="action" value="upload_permis">
                                <label class="doc-upload-btn">
                                    Envoyer mon permis
                                    <input type="file" name="permis"
                                           accept="image/*,application/pdf"
                                           onchange="this.form.submit()" hidden>
                                </label>
                            </form>
                        <?php endif; ?>

                    <?php else: ?>

                        <div class="doc-status doc-missing">⚠ Aucun permis</div>

                        <form method="post" enctype="multipart/form-data" class="doc-upload-form">
                            <input type="hidden" name="action" value="upload_permis">
                            <label class="doc-upload-btn">
                                Envoyer mon permis
                                <input type="file" name="permis"
                                       accept="image/*,application/pdf"
                                       onchange="this.form.submit()" hidden>
                            </label>
                        </form>

                    <?php endif; ?>

                </div>
            </div>

        </div>
    </section>



    <!-- historique rapide -->
    <section class="account-card">
        <div class="account-header-row">
            <h2>Historique rapide</h2>
            <a href="index.php?page=mestrajets" class="link-more">Voir tous mes trajets</a>
        </div>

        <?php if (empty($history)): ?>
            <p style="color:#777;">Aucun trajet encore enregistré.</p>

        <?php else: ?>

            <div class="history-grid">

                <?php foreach ($history as $h):
                    $isFuture  = $h['future'];
                    $cardClass = $isFuture ? 'history-card-future' : 'history-card-past';
                    $roleLabel = $h['role']==='conducteur'
                                ? "En tant que conducteur"
                                : "En tant que passager";
                ?>

                    <div class="history-card <?= $cardClass ?>">
                        <div class="history-title">
                            <?= htmlspecialchars($h['depart']) ?> →
                            <?= htmlspecialchars($h['arrivee']) ?>
                        </div>

                        <div class="history-price">
                            <?= htmlspecialchars($h['prix']) ?> €
                        </div>

                        <div class="history-role"><?= $roleLabel ?></div>
                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </section>



    <!-- sécurité -->
    <section class="account-card account-security">

        <h2>Sécurité</h2>

        <p class="security-text">
            Gérez vos informations sensibles. Pour des raisons de sécurité,
            les modifications se font via un lien temporaire protégé par un token.
        </p>

        <div class="security-grid">

            <div class="security-item">
                <h3>Mot de passe</h3>
                <p>Modifiez votre mot de passe de connexion.</p>
                <a href="index.php?page=forgot" class="security-btn">
                    Modifier mon mot de passe
                </a>
            </div>

            <div class="security-item">
                <h3>Adresse e-mail</h3>
                <p>Adresse actuelle :
                    <strong><?= htmlspecialchars($user['email']) ?></strong>
                </p>
                <a href="index.php?page=change_email" class="security-btn">
                    Modifier mon adresse e-mail
                </a>
            </div>

        </div>

    </section>


</main>

<?php include __DIR__ . '/footer.php'; ?>

<script src="/Caramba/public/js/prefButtons.js"></script>
<script src="/Caramba/public/js/flashMessages.js"></script>
<script src="/Caramba/public/js/preventCache.js"></script>

</body>
</html>
