<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publier un trajet - Caramba</title>
    <link rel="icon" type="png" href="/Caramba/public/img/Caramba-logo.png">
    <link rel="stylesheet" href="/Caramba/public/css/style.css">
    <link rel="stylesheet" href="/Caramba/public/css/responsive.css">
     <!-- Flatpickr (calendrier) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>
</head>
<body>

<?php include __DIR__ . "/navbar.php"; ?>

<section class="publish-container">

    <h1>Publier un trajet</h1>

    <!-- Message profil incomplet -->
    <?php if (!empty($profil_incomplet)): ?>
        <div class="profile-warning">
            <strong>⚠ Votre profil est incomplet.</strong><br>
            Vous devez compléter : <?= implode(", ", $manques); ?>.<br>
            <a href="index.php?page=profil" class="btn-edit-profile">Compléter mon profil</a>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['flash_success'])): ?>
    <div class="flash-success flash-msg">
        <?= $_SESSION['flash_success']; ?>
        <span class="close-flash">×</span>
    </div>
    <?php unset($_SESSION['flash_success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="flash-error flash-msg">
            <?= $_SESSION['flash_error']; ?>
            <span class="close-flash">×</span>
        </div>
        <?php unset($_SESSION['flash_error']); ?>
    <?php endif; ?>

    <!-- Message direct -->
    <?= $message ?? '' ?>

    <form class="publish-box" method="POST">

        <input type="hidden" name="action" value="publier">

        <!-- depart -->
        <label>Ville de départ *</label>
        <div class="ville-wrapper">
            <input type="text" name="depart" id="ville-depart" required 
                   placeholder="Saisissez une ville..." autocomplete="off">
            <div class="suggestions" id="suggestions-depart"></div>
        </div>

        <!-- arrivée -->
        <label>Ville d’arrivée *</label>
        <div class="ville-wrapper">
            <input type="text" name="arrivee" id="ville-arrivee" required 
                   placeholder="Saisissez une ville..." autocomplete="off">
            <div class="suggestions" id="suggestions-arrivee"></div>
        </div>

        <label>Date du départ *</label>
        <input type="date" name="date_depart" required>

        <label>Heure du départ *</label>
        <input type="time" name="heure_depart" required>

        <label>Prix (€) *</label>
        <input type="number" step="0.50" name="prix" min="0" required>

        <label>Nombre de places disponibles *</label>
        <input type="number" name="places" min="1" max="6" required>

        <label>Description (optionnel)</label>
        <textarea name="description" placeholder="Infos supplémentaires..."></textarea>

        <button type="submit" class="submit-publish">Publier mon trajet</button>

    </form>

</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    flatpickr("input[name='date_depart']", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d/m/Y",
        disableMobile: true,
        allowInput: true,
        locale: "fr",
        minDate: "today",
        defaultDate: "today"
    });
});
</script>

<script>
    const villes = [
        <?php foreach($villes as $v): ?>
            "<?= addslashes($v['nom']) ?>",
        <?php endforeach; ?>
    ];

    function setupAutocomplete(inputId, boxId) {
        const input = document.getElementById(inputId);
        const box = document.getElementById(boxId);

        input.addEventListener("input", () => {
            const search = input.value.toLowerCase();
            box.innerHTML = "";

            if (search.length < 2) {
                box.style.display = "none";
                return;
            }

            const results = villes
                .filter(v => v.toLowerCase().startsWith(search))
                .slice(0, 8);

            results.forEach(city => {
                const item = document.createElement("div");
                item.className = "suggestion-item";
                item.textContent = city;

                item.onclick = () => {
                    input.value = city;
                    box.style.display = "none";
                };

                box.appendChild(item);
            });

            box.style.display = results.length ? "block" : "none";
        });

        document.addEventListener("click", e => {
            if (!box.contains(e.target) && e.target !== input) {
                box.style.display = "none";
            }
        });
    }

    setupAutocomplete("ville-depart", "suggestions-depart");
    setupAutocomplete("ville-arrivee", "suggestions-arrivee");
</script>

<script src="/Caramba/public/js/preventCache.js"></script>
<script src="/Caramba/public/js/flashMessages.js"></script>

<?php include __DIR__ . '/footer.php'; ?>

</body>
</html>
