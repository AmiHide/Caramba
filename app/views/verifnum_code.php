<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code de vérification - Caramba</title>
    <link rel="icon" type="png" href="/Caramba/public/img/Caramba-logo.png">
    <link rel="stylesheet" href="/Caramba/public/css/style.css">
    <link rel="stylesheet" href="/Caramba/public/css/responsive.css">
</head>
<body>

<?php include __DIR__ . '/navbar.php'; ?>

<div class="account-container">

    <h1>Confirmez votre code</h1>

    <div class="verify-box">

        <h3>Entrez le code reçu par SMS</h3>

        <?php if (!empty($_GET['error'])): ?>
            <div class="error-message" style="color:red; margin-bottom:10px;">
                Code incorrect ou expiré. Veuillez réessayer.
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=verifnum_check">
            <div class="field">
                <label>Code à 6 chiffres</label>
                <input type="text" name="code" maxlength="6" required>
            </div>

            <button type="submit" class="btn-verify-phone">
                Valider le code
            </button>
        </form>

        <div style="margin-top:15px; text-align:center;">
            <a href="index.php?page=verifnum" style="color:#555; font-size:14px;">
                Renvoyer le code
            </a>
        </div>

    </div>

</div>

<?php include __DIR__ . '/footer.php'; ?>

</body>
</html>
