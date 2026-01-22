<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche - Caramba</title>
    <link rel="icon" type="png" href="/Caramba/public/img/Caramba-logo.png">
    <link rel="stylesheet" href="/Caramba/public/css/style.css">
    <link rel="stylesheet" href="/Caramba/public/css/responsive.css">

    <!-- Flatpickr (calendrier) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>
</head>

<body>

<?php include __DIR__ . '/navbar.php'; ?>
<div id="loader" class="loader hidden"></div>
<section class="search-header">
    
    <h1>Recherchez votre prochain trajet</h1>

    <form class="search-top" action="index.php" method="GET">

        <input type="hidden" name="page" value="recherche">

        <div class="field">
            <label>Départ</label>
            <input type="text" name="depart" id="departInput" class="city-input" 
                   placeholder="Ville de départ" autocomplete="off"
                   value="<?= htmlspecialchars($depart) ?>" required>
            <div id="departList" class="autocomplete-list"></div>
            <?php include __DIR__ . '/../controllers/Auto_list_ville.php'; ?>
            <script>
                setupAutocomplete("departInput", "departList"); 
                setupAutocomplete("arriveeInput", "arriveeList"); 
            </script>
        </div>

        <div class="field">
            <label>Arrivée</label>
            <input type="text" name="arrivee" id="arriveeInput" class="city-input" 
                   placeholder="Ville d'arrivée" autocomplete="off"
                   value="<?= htmlspecialchars($arrivee) ?>" required>
            <div id="arriveeList" class="autocomplete-list"></div>
            <?php include __DIR__ . '/../controllers/Auto_list_ville.php'; ?>
            <script>
                setupAutocomplete("departInput", "departList"); 
                setupAutocomplete("arriveeInput", "arriveeList"); 
            </script>
        </div>

        <div class="field date-field">
            <label>Date</label>

            <div class="date-input-wrapper">
                <input type="date" name="date" value="<?= htmlspecialchars($date) ?>" required>

            
                <span class="date-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="4"></rect>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </span>
            </div>
        </div>

        <div class="field">
            <label>Passager(s)</label>
            <input type="number" min="1" max="6" name="passagers"
                value="<?= htmlspecialchars($passagers) ?>" required>
        </div>

        <button class="btn-search">Rechercher</button>

    </form>

</section>



<div class="recherche-container">

    <aside class="filtres">

        <h3>Filtres</h3>

        <form method="GET" class="filtres-form">

            <input type="hidden" name="page" value="recherche">
            <input type="hidden" name="depart" value="<?= htmlspecialchars($depart) ?>">
            <input type="hidden" name="arrivee" value="<?= htmlspecialchars($arrivee) ?>">
            <input type="hidden" name="date" value="<?= htmlspecialchars($date) ?>">
            <input type="hidden" name="passagers" value="<?= htmlspecialchars($passagers) ?>">

            <label>Prix maximum</label>
            <input type="number" name="prix_max" min="1" max="300"
                value="<?= $_GET['prix_max'] ?? '' ?>" placeholder="€">

            <label>Trier par</label>
            <select name="tri">
                <option value="prix_asc"   <?= ($filters['tri'] ?? '') === 'prix_asc'   ? 'selected' : '' ?>>Le moins cher</option>
                <option value="prix_desc"  <?= ($filters['tri'] ?? '') === 'prix_desc'  ? 'selected' : '' ?>>Le plus cher</option>
                <option value="recents"    <?= ($filters['tri'] ?? '') === 'recents'    ? 'selected' : '' ?>>Les plus récents</option>
            </select>

<hr style="margin:15px 0; border:0; border-top:1px solid #eee;">

<h4 style="font-size:20px;margin-bottom:15px;">Préférences</h4>

<!-- musique -->
<label class="pref-check">
    <input type="checkbox" name="musique" value="1"
           <?= isset($_GET["musique"]) ? "checked" : "" ?>>
    <span class="check-box"></span>
    Musique autorisée
    <span class="pref-icon">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="_1rks9rr0 ejccx3ku ejccx3f"><g color="neutralTxtModerate"><g color="currentColor"><path fill="currentColor" fill-rule="evenodd" d="M9 2h12a1 1 0 0 1 1 1v13a3.75 3.75 0 1 1-1.5-3V7h-11v11.25a3.75 3.75 0 1 1-1.5-3V3a1 1 0 0 1 1-1m.5 1.5v2h11v-2zm11 12.5a2.25 2.25 0 1 0-4.5 0 2.25 2.25 0 0 0 4.5 0M5.75 16A2.25 2.25 0 0 1 8 18.249v.001A2.25 2.25 0 1 1 5.75 16" clip-rule="evenodd"></svg>
    </span>
</label>

<!-- fumeur -->
<label class="pref-check">
    <input type="checkbox" name="fumeur" value="1"
           <?= isset($_GET["fumeur"]) ? "checked" : "" ?>>
    <span class="check-box"></span>
    Cigarette autorisée
    <span class="pref-icon">
        <svg viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd"
        d="M3.5 16.5v2h14v-2zM3 15a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h16v-5zm17.5 5v-5H22v5zm.75-16v1.25a3.74 3.74 0 0 1-1.471 2.978A4.75 4.75 0 0 1 22 12.25v1.25h-1.5v-1.25A3.25 3.25 0 0 0 17.25 9H17V7.5h.5a2.25 2.25 0 0 0 2.25-2.25V4zm-7.25 2.5a2.25 2.25 0 0 0 0 4.5h2.5a2.5 2.5 0 0 1 2.5 2.5h-1.5a1 1 0 0 0-1-1H14A3.75 3.75 0 1 1 14 5z"/></svg>
    </span>
</label>

<!-- animaux -->
<label class="pref-check">
    <input type="checkbox" name="animaux" value="1"
           <?= isset($_GET["animaux"]) ? "checked" : "" ?>>
    <span class="check-box"></span>
    Animaux autorisés
    <span class="pref-icon">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="_1rks9rr0 ejccx3ku ejccx3f"><g color="neutralTxtModerate"><g color="currentColor"><path fill="currentColor" fill-rule="evenodd" d="M8.75 4a2.75 2.75 0 1 1 .002 5.5A2.75 2.75 0 0 1 8.75 4M10 6.75a1.25 1.25 0 1 1-2.5 0 1.25 1.25 0 0 1 2.5 0M5.163 9.03A2.754 2.754 0 0 1 7.5 11.75a2.75 2.75 0 1 1-2.337-2.72M6 11.75a1.25 1.25 0 1 1-2.5 0 1.25 1.25 0 0 1 2.5 0M15.25 9.5a2.75 2.75 0 1 1-.002-5.5 2.75 2.75 0 0 1 .002 5.5m0-1.5a1.25 1.25 0 1 1 0-2.5 1.25 1.25 0 0 1 0 2.5M16.687 10.75A2.75 2.75 0 0 1 19.25 9a2.75 2.75 0 1 1-2.563 1.75M19.25 13a1.25 1.25 0 1 1 0-2.5 1.25 1.25 0 0 1 0 2.5M7.182 15.255l2.784-3.897a2.5 2.5 0 0 1 4.069 0l2.783 3.897c1.615 2.261-.446 5.313-3.147 4.66l-.73-.177a4 4 0 0 0-1.882 0l-.73.177c-2.7.654-4.762-2.399-3.147-4.66m1.22.872 2.784-3.897a1 1 0 0 1 1.628 0l2.783 3.897c.808 1.13-.223 2.657-1.573 2.33l-.73-.177a5.5 5.5 0 0 0-2.588 0l-.73.177c-1.35.327-2.38-1.2-1.573-2.33" clip-rule="evenodd"></path></g></g></svg>
    </span>
</label>
            <button type="submit" class="btn-filtrer">Appliquer</button>

        </form>

    </aside>


    <section class="resultats">

        <h2>Résultats de la recherche</h2>
        <?php if (!empty($trajets)): ?>
    <div class="result-count">
        <?= count($trajets) ?> trajet<?= count($trajets) > 1 ? 's' : '' ?> trouvé<?= count($trajets) > 1 ? 's' : '' ?>
        pour votre recherche
    </div>
<?php endif; ?>

        <?php if (!$depart || !$arrivee || !$date): ?>

            <p class="empty-info">⛔ Veuillez remplir tous les champs pour lancer une recherche.</p>

        <?php else: ?>

            <?php if (empty($trajets)): ?>

                <p class="no-results">Aucun trajet trouvé pour cette recherche…</p>


            <?php else: ?>

                <?php foreach ($trajets as $t): ?>

                    <div class="trajet-card">

                        <div class="trajet-left">

                            <a href="index.php?page=voirprofil&id=<?= $t['conducteur_id'] ?>" 
                            class="driver-link"
                            style="display:flex; gap:12px; align-items:center; position:relative;">

                                <div class="driver-avatar-wrapper">
                                    <img src="/Caramba/public/uploads/avatars/<?= htmlspecialchars($t['avatar'] ?? 'user-icon.png') ?>" 
                                        class="trajet-avatar">

                                    <?php if (User::isSuperDriver($t['conducteur_id'])): ?>
                                        <img src="/Caramba/public/img/superdriver.svg"
                                            class="superdriver-overlay"
                                            alt="Super Driver">
                                    <?php endif; ?>
                                </div>

                                <?php
                                    $prenomTab = explode(' ', trim($t['nom']));
                                    $prenom = ucfirst(strtolower($prenomTab[0]));
                                ?>

                                <p class="trajet-driver"><?= htmlspecialchars($prenom) ?></p>

                            </a>


                            <p class="trajet-hour">
                                Heure de départ : <?= substr($t['heure_depart'], 0, 5) ?>
                            </p>

                        </div>

                        <div class="trajet-middle">
                            <p class="trajet-route">
                                <?= htmlspecialchars($t['depart']) ?> →
                                <?= htmlspecialchars($t['arrivee']) ?>
                            </p>
                            <p class="trajet-desc"><?= nl2br(htmlspecialchars($t['description'])) ?></p>
                        </div>

                        <div class="trajet-right">
                            <p class="trajet-price"><?= $t['prix'] ?> €</p>
                            <p class="trajet-places"><?= $t['places_disponibles'] ?> place(s)</p>

                            <a href="index.php?page=reserver&id=<?= $t['id'] ?>" 
                               class="btn-reserver" target="_blank">
                                Réserver
                            </a>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        <?php endif; ?>

    </section>

</div>




<script>
document.addEventListener("DOMContentLoaded", function() {
  flatpickr("input[type='date']", {
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "d/m/Y",
    disableMobile: true,
    allowInput: true,
    locale: "fr",
    minDate: "today",
    shorthandCurrentMonth: false,
    weekNumbers: false,
    static: false,
    defaultDate: new Date() 
  });
});

</script>


<?php include __DIR__ . '/footer.php'; ?>

<script src="js/autocomplete.js"></script>

<script src="/Caramba/public/js/preventCache.js"></script>

<script>
document.querySelector(".btn-search").addEventListener("click", function () {
    document.getElementById("loader").classList.remove("hidden");

    // petit délai pour laisser le loader s'afficher avant redirection
    setTimeout(() => {
        this.closest("form").submit();
    }, 150);
});
</script>


</body>
</html>
