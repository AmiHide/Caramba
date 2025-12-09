<?php
session_start();

$toast = "";
if (isset($_SESSION["login_success"])) {
    $toast = $_SESSION["login_success"];
    unset($_SESSION["login_success"]);
}
?>
<?php
require "config.php";

// Récupérer toutes les villes
$req = $pdo->query("SELECT nom FROM villes ORDER BY nom ASC");
$villes = $req->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les 6 derniers avis
$reqAvis = $pdo->query("
    SELECT a.*, u.nom, u.pseudo, u.avatar
    FROM avis a
    JOIN users u 
        ON (CASE 
                WHEN a.auteur_role = 'passager' THEN a.passager_id = u.id 
                ELSE a.conducteur_id = u.id 
            END)
    ORDER BY a.date_avis DESC
    LIMIT 6
");
$avis = $reqAvis->fetchAll(PDO::FETCH_ASSOC);

?>



<!DOCTYPE html>
<html lang="fr">

<!-- Onglet du site -->
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Caramba</title>
  <link rel="icon" type="png" href="img/logo_site.png">
  <link rel="stylesheet" href="style.css">
</head>

<body>
      <?php if (isset($_GET['success']) && $_GET['success'] === 'avis') : ?>
    <div class="popup-success" id="popupSuccess">
        Votre avis a bien été envoyé !
    </div>

    <script>
        setTimeout(() => {
            const popup = document.getElementById("popupSuccess");
            if (popup) popup.style.opacity = "0";
        }, 3000);
    </script>
<?php endif; ?>

  <?php include 'navbar.php'; ?>

<div id="toast" class="toast hidden"></div>

  <main class="main-content">

    <!-- Encadrer recherche de trajet -->
    <form class="search-box" action="recherche.php" method="GET">

      <!-- Section ville de départ -->
      <label>Ville de départ</label>
      <div class="input-field">
        <img src="img/Pin.png" alt="icon" class="icon">
        <input type="text" name="depart" id="departInput" class="city-input" placeholder="Départ" autocomplete="off" required>
        <div id="departList" class="autocomplete-list"></div>
      </div>

      <!-- Section ville d'arrivée -->
      <label>Ville d’arrivée</label>
      <div class="input-field">
        <img src="img/Pin.png" alt="icon" class="icon">
        <input type="text" name="arrivee" id="arriveeInput" class="city-input" placeholder="Arrivée" autocomplete="off" required>
        <div id="arriveeList" class="autocomplete-list"></div>
      </div>


      <!-- Date de départ -->
      <label>Date de départ</label>
      <div class="input-field">
        <input type="date" name="date" id="dateDepart" required>
      </div>

      <!-- Section Nombre de passagers -->
      <label>Nombre de passagers</label>
      <div class="input-field passengers">
        <img src="img/user.png" alt="icon" class="icon">
        <input type="number" min="1" max="6" value="1" name="passagers" id="passengers" required>
        <span>Passager</span>
      </div>
      <!-- Bouton -->
      <button type="submit" class="search-btn">Rechercher</button>

  </form>

    <section class="hero-text">
      <h1>Réservez malin,<br>Choisissez Caramba</h1>
    
  </main>
  <!-- Section avantages -->
    <section class="avantages">
      <h2>Voyager avec Caramba c’est :</h2>

      <div class="avantage-container">
        <div class="avantage">
          <img src="img/tirelire.png" alt="avt" class="avt">
          <h3>Des économies :</h3>
          <p>Pas la peine de casser votre tirelire pour vos voyages.</p>
        </div>

        <div class="avantage">
          <img src="img/voyage_convi.png" alt="avt" class="avt">
          <h3>Un voyage convivial :</h3>
          <p>Avec Caramba, voyagez dans un cadre convivial et agréable.</p>
        </div>

        <div class="avantage">
          <img src="img/Ecologie.png" alt="avt" class="avt">
          <h3>Écologie :</h3>
          <p>Protégez la planète en choisissant Caramba pour vos déplacements.</p>
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

          <h3>D’où vient l’idée Caramba</h3>
          <p>
            Nous avons pu réaliser de nombreux voyages en covoiturage et avons remarqué qu’il y avait 
            toujours un effet PUB VS la vie. D’où l’idée de Caramba qui a pour but d’être authentique, 
            sans faux-semblant.
          </p>
        </div>

        <div class="about-image">
          <img src="img/Caramba-logo-text.png" alt="Logo">
        </div>
      </div>  
    </section>

<!-- Section sécurité -->
  <section class="securite-section">
    <div class="securite-container">
      <div class="texte">
        <h2>Votre sécurité avant tout</h2>
        <p>
          Chez CARAMBA, la confiance est au cœur de chaque trajet. 
          Tous nos utilisateurs sont vérifiés et peuvent laisser des avis après chaque covoiturage, 
          afin de garantir une communauté fiable et bienveillante. Grâce à notre système d’évaluations, 
          à la vérification d’identité et au suivi en temps réel des trajets, vous voyagez en toute sérénité. 
          Avec CARAMBA, partagez la route en toute confiance.
        </p>
        <a href="securite.html" class="btn">En savoir plus</a>
      </div>
      <div class="image">
        <img src="img/covoiturage.png" alt="Personnes dans une voiture">
      </div>
    </div>
  </section>

<!-- Section avis clients -->
  <section class="avis-section">
    <h2>Avis clients</h2>
    <div class="avis-container">

        <?php foreach ($avis as $a): ?>
            <div class="avis-card">
                <p class="avis-message">“<?= htmlspecialchars($a['commentaire']) ?>”</p>

                <div class="avis-user">
                    <img src="uploads/avatars/<?= htmlspecialchars($a['avatar']) ?>" alt="avatar">

                    <div>
                        <p class="avis-nom"><?= htmlspecialchars($a['nom']) ?></p>
                        <p class="avis-id">@<?= htmlspecialchars($a['pseudo']) ?></p>

                        <p class="etoiles">
                            <?php 
                                $stars = str_repeat("★", (int)$a['note']) . str_repeat("☆", 5 - (int)$a['note']);
                                echo $stars;
                            ?>
                        </p>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</section>





<?php include 'footer.php'; ?>

<script src="script.js"></script>
  
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
document.addEventListener("DOMContentLoaded", () => {
    const dropdown = document.querySelector(".profile-dropdown");
    if (!dropdown) return;

    dropdown.addEventListener("click", () => {
        dropdown.classList.toggle("active");
    });

    document.addEventListener("click", e => {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove("active");
        }
    });
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
updateLabel(); // lance au chargement
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let villes = [
        <?php foreach ($villes as $v): ?>
            "<?= addslashes($v['nom']) ?>",
        <?php endforeach; ?>
    ];

    function setupAutocomplete(inputId, listId) {
        const input = document.getElementById(inputId);
        const list  = document.getElementById(listId);

        input.addEventListener("input", function () {
            const val = this.value.toLowerCase();
            list.innerHTML = "";

            if (val === "") {
                list.style.display = "none";
                return;
            }

            const matches = villes.filter(v => v.toLowerCase().includes(val));

            if (matches.length === 0) {
                list.style.display = "none";
                return;
            }

            matches.forEach(v => {
                const item = document.createElement("div");
                item.textContent = v;
                item.addEventListener("click", () => {
                    input.value = v;
                    list.style.display = "none";
                });
                list.appendChild(item);
            });

            list.style.display = "block";
        });

        document.addEventListener("click", function (e) {
            if (!list.contains(e.target) && e.target !== input) {
                list.style.display = "none";
            }
        });
    }

    setupAutocomplete("departInput", "departList");
    setupAutocomplete("arriveeInput", "arriveeList");
});

</script>

</body>
</html>