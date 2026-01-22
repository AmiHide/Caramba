<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte – Caramba</title>
    <link rel="icon" type="png" href="/Caramba/public/img/Caramba-logo.png">
    <link rel="stylesheet" href="/Caramba/public/css/style.css">
    <link rel="stylesheet" href="/Caramba/public/css/responsive.css">
</head>

<body>

<?php include __DIR__ . '/navbar.php'; ?>

<section class="register-header">
    <h1>Créer un nouveau compte</h1>
</section>

<main class="register-content">

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

    <form class="card" action="index.php?page=register" method="POST" enctype="multipart/form-data" id="formRegister">
        <div class="grid">

            <div class="col-1">
                <label>Prénom *</label>
                <div class="input-field">
                    <input type="text" name="prenom" required>
                </div>
            </div>

            <div class="col-1">
                <label>Nom *</label>
                <div class="input-field">
                    <input type="text" name="nom" required>
                </div>
            </div>

            <div class="col-2">
                <label>Sexe *</label>
                <div class="seg">
                    <input type="radio" name="sexe" id="homme" value="Homme" required>
                    <label for="homme">Homme</label>

                    <input type="radio" name="sexe" id="femme" value="Femme">
                    <label for="femme">Femme</label>

                    <input type="radio" name="sexe" id="autre" value="autre">
                    <label for="autre">Autre</label>
                </div>
            </div>

            <div class="col-2">
                <label>Date de naissance *</label>
                <div class="input-field">
                    <input type="date" name="naissance" required max="<?= date('Y-m-d', strtotime('-18 years')); ?>" min="<?= date('Y-m-d', strtotime('-100 years')); ?>">
                </div>
            </div>

            <div class="col-2">
                <label>Téléphone *</label>
                <div class="input-field">
                    <input type="tel" name="tel" required>
                </div>
            </div>

            <div class="col-2">
                <label>Région *</label>
                <div class="input-field">
                    <select name="region" required>
                        <option>Ile-de-France</option>
                        <option>Auvergne-Rhône-Alpes</option>
                        <option>Occitanie</option>
                        <option>Provence-Alpes-Côte d’Azur</option>
                        <option>Nouvelle-Aquitaine</option>
                        <option>Hauts-de-France</option>
                        <option>Grand Est</option>
                        <option>Bretagne</option>
                        <option>Normandie</option>
                        <option>Pays de la Loire</option>
                        <option>Bourgogne-Franche-Comté</option>
                        <option>Centre-Val de Loire</option>
                        <option>Corse</option>
                        <option>Outre-mer</option>
                    </select>
                </div>
            </div>

            <div class="col-2">
                <label>Je veux être conducteur *</label>
                <div class="seg">
                    <input type="radio" name="conducteur" id="yes" value="Oui" required>
                    <label for="yes">Oui, je conduis</label>

                    <input type="radio" name="conducteur" id="no" value="Non">
                    <label for="no">Non, je ne conduis pas</label>
                </div>
            </div>

            <div class="col-2 fiel">
                <label>Preuve d'identité *</label>
                <label class="file file-input">
                    <span>Ajouter fichier</span>
                    <input type="file" name="idfile" accept="image/*,.pdf" required>
                </label>
                <small style="color:#666; font-style:italic;">
                    Formats acceptés : JPG, PNG, PDF - Maximum 5 Mo
                </small>
            </div>

            <div class="col-2 fiel">
                <label>Permis (si conducteur)</label>
                <label class="file file-input">
                    <span>Ajouter fichier</span>
                    <input type="file" name="driverfile" id="permis-input" accept="image/*,.pdf">
                </label>
                <small style="color:#666; font-style:italic;">
                    Formats acceptés : JPG, PNG, PDF - Maximum 5 Mo
                </small>
            </div>

            <div class="col-2">
                <label>Pseudo *</label>
                <div class="input-field">
                    <input type="text" name="username" required>
                </div>
            </div>

            <div class="col-2">
                <label>Email *</label>
                <div class="input-field">
                    <input type="email" name="email" required>
                </div>
            </div>

            <div class="col-2">
                <label>Mot de passe *</label>
                <div class="input-field">
                    <input type="password" name="password" id="password" required minlength="8">
                </div>
            </div>

            <div class="col-2">
                <label>Confirmation du mot de passe *</label>
                <div class="input-field">
                    <input type="password" name="password2" id="password2" required minlength="8">
                </div>
                <p id="pwdError" style="color:#E74C3C; font-weight:bold; display:none;">
                    ⚠️ Les mots de passe ne correspondent pas.
                </p>
            </div>

            <div class="col-3 checks">
                <label><input type="checkbox" name="cgu" required> J'ai lu et j'accepte les conditions générales d'utilisation</label>
                <label><input type="checkbox" name="newsletter"> Je souhaite qu'on m'informe par mail des nouveautés</label>
            </div>

            <div class="col-3 foot">
                Déjà membre ? <a href="index.php?page=connexion">Connexion</a>
            </div>

            <div class="col-2 actions">
                <button type="submit" class="submit">Soumettre</button>
            </div>

        </div>
    </form>

</main>

<?php include __DIR__ . '/footer.php'; ?>

<script>
function shortenFileName(name, max = 10) {
    const dotIndex = name.lastIndexOf(".");
    if (dotIndex === -1) return name; // Pas d'extension

    const base = name.substring(0, dotIndex);
    const ext = name.substring(dotIndex);

    if (base.length <= max) return name;

    return base.substring(0, max) + "..." + ext;
}

document.querySelectorAll(".file-input input[type='file']").forEach(input => {
    input.addEventListener("change", function () {
        let fileName = this.files.length ? this.files[0].name : "Ajouter fichier";
        
        fileName = shortenFileName(fileName, 10); // limite à 10 caractères

        this.previousElementSibling.textContent = fileName;
    });
});
</script>

<script>
document.getElementById("formRegister").addEventListener("submit", function(e){
    let p1 = document.getElementById("password").value;
    let p2 = document.getElementById("password2").value;

    if (p1 !== p2) {
        document.getElementById("pwdError").style.display = "block";
        e.preventDefault();
    }
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {

    const radios = document.querySelectorAll("input[name='conducteur']");
    const permisInput = document.getElementById("permis-input");

    function updateRequirement() {
        const value = document.querySelector("input[name='conducteur']:checked")?.value;

        if (value === "Oui") {
            permisInput.required = true;
        } else {
            permisInput.required = false;
        }
    }

    radios.forEach(r => r.addEventListener("change", updateRequirement));

    updateRequirement();
});
</script>

<script src="/Caramba/public/js/flashMessages.js"></script>


</body>
</html>
