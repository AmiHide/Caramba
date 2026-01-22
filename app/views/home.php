<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Caramba</title>
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

<div id="toast" class="toast hidden"></div>

<main class="main-content">

    <form class="search-box" action="index.php" method="GET">
    <input type="hidden" name="page" value="recherche">
    
      <label>Ville de départ</label>
      <div class="input-field">
        <img src="/Caramba/public/img/Pin.png" alt="icon" class="icon">
        <input type="text" name="depart" id="ville-depart" class="city-input" placeholder="Départ" autocomplete="off" required>
        <div id="suggestions-depart" class="autocomplete-list"></div>
        <?php include __DIR__ . '/../controllers/Auto_list_ville.php'; ?>
          <script>
            setupAutocomplete("departInput", "departList"); 
            setupAutocomplete("arriveeInput", "arriveeList"); 
          </script>
      </div>

      <label>Ville d'arrivée</label>
      <div class="input-field">
        <img src="/Caramba/public/img/Pin.png" alt="icon" class="icon">
        <input type="text" name="arrivee" id="ville-arrivee" class="city-input" placeholder="Arrivée" autocomplete="off" required>
        <div id="suggestions-arrivee" class="autocomplete-list"></div>
        <?php include __DIR__ . '/../controllers/Auto_list_ville.php'; ?>
          <script>
            setupAutocomplete("departInput", "departList"); 
            setupAutocomplete("arriveeInput", "arriveeList"); 
          </script>
      </div>

<label>Date de départ</label>
<div class="input-field date-input-wrapper">

  <!-- Icône calendrier à gauche -->
  <span class="date-icon-home">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000"
         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="4" width="18" height="18" rx="4"></rect>
        <line x1="8" y1="2" x2="8" y2="6"></line>
        <line x1="16" y1="2" x2="16" y2="6"></line>
        <line x1="3" y1="10" x2="21" y2="10"></line>
    </svg>
  </span>

  <input type="date" name="date" id="dateDepart" required>

</div>


      <label>Nombre de passagers</label>
      <div class="input-field passengers">
        <img src="/Caramba/public/img/user.png" alt="icon" class="icon">
        <input type="number" min="1" max="6" value="1" name="passagers" id="passengers" required>
        <span>Passager</span>
      </div>

      <button type="submit" class="search-btn">Rechercher</button>

    </form>

    <section class="hero-text">
      <h1>Réservez malin,<br>Choisissez Caramba</h1>
    </section>

</main>

<section class="avantages">
  <h2>Voyager avec Caramba c'est :</h2>

  <div class="avantage-container">
    <div class="avantage">
      <img src="/Caramba/public/img/tirelire.png" alt="avt" class="avt">
      <h3>Des économies :</h3>
      <p>Pas la peine de casser votre tirelire.</p>
    </div>

    <div class="avantage">
      <img src="/Caramba/public/img/voyage_convi.png" alt="avt" class="avt">
      <h3>Un voyage convivial :</h3>
      <p>Voyagez dans un cadre agréable.</p>
    </div>

    <div class="avantage">
      <img src="/Caramba/public/img/Ecologie.png" alt="avt" class="avt">
      <h3>Écologie :</h3>
      <p>Protégez la planète en covoiturant.</p>
    </div>
  </div>
</section>

<!-- Section A propos -->
    <section class="about">
      <div class="about-content">
        <div class="about-text">
          <h2>Qui sommes nous ?</h2>

          <h3>Nous sommes CARAMBA</h3>
          <p>
            Un projet développé par Specialinks. Un petit groupe parisien de moins de 10 personnes, 
            tous engagés au développement du covoiturage !
          </p>

          <h3>D'où vient l'idée Caramba</h3>
          <p>
            Nous avons pu réaliser de nombreux voyages en covoiturage et avons remarqué qu'il y avait 
            toujours un effet PUB VS la vie. D'où l'idée de Caramba qui a pour but d'être authentique, 
            sans faux-semblant.
          </p>
        </div>

        <div class="about-image">
          <img src="/Caramba/public/img/Caramba-logo-text.png" alt="Logo">
        </div>
      </div>  
    </section>

<section class="avis-section">
    <h2>Avis récents</h2>

    <div class="avis-container">
        <?php foreach ($avisList as $av): ?>

            <?php
            $parts = explode(' ', $av['auteur_nom']);
            $prenom = ucfirst(strtolower($parts[0]));
            $nomComplet = strtoupper(implode(' ', array_slice($parts, 1)));
            $displayNom = $prenom . ' ' . $nomComplet;

            $avatar = !empty($av['auteur_avatar'])
                ? "/Caramba/public/uploads/avatars/{$av['auteur_avatar']}"
                : "/Caramba/public/uploads/avatars/user-icon.png";
            ?>

            <div class="avis-card">
                <p class="avis-message">“<?= htmlspecialchars($av['commentaire']) ?>”</p>

                <div class="avis-note">
                    <?php for ($i=1; $i<=5; $i++): ?>
                        <span class="star <?= $i <= $av['note'] ? 'filled' : '' ?>">★</span>
                    <?php endfor; ?>
                </div>

                <div class="avis-user">
                    <img src="<?= $avatar ?>" alt="Avatar">
                    <div>
                        <p class="avis-nom"><?= htmlspecialchars($displayNom) ?></p>
                        <p class="avis-id"><?= htmlspecialchars($av['depart']) ?> → <?= htmlspecialchars($av['arrivee']) ?></p>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
  flatpickr("input[type='date']", {
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "d/m/Y",
    disableMobile: true,
    allowInput: true,
    locale: "fr",
    shorthandCurrentMonth: false,
    weekNumbers: false,
    minDate: "today",
    static: false,
    defaultDate: new Date() 
  });
});

</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const toastMessage = "<?= $toast ?>";
    if (toastMessage !== "") {
        const toast = document.getElementById("toast");
        toast.textContent = toastMessage;
        toast.classList.remove("hidden");

        setTimeout(() => toast.classList.add("show"), 100);

        setTimeout(() => {
            toast.classList.remove("show");
        }, 3000);
    }
});
</script>

<script>
const inputPassagers = document.getElementById('passengers');
const labelPassagers = inputPassagers.nextElementSibling;

function updateLabel() {
    const n = parseInt(inputPassagers.value);
    labelPassagers.textContent = n > 1 ? "Passagers" : "Passager";
}

inputPassagers.addEventListener("input", updateLabel);
updateLabel();
</script>

<script>
window.autocompleteVilles = [
    <?php foreach ($villes as $v): ?>
        "<?= addslashes($v['nom']) ?>",
    <?php endforeach; ?>
];
</script>

<script src="js/autocomplete.js"></script>
<script src="js/preventCache.js"></script>

</body>
</html>