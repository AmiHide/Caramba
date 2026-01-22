<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification du numéro - Caramba</title>
    <link rel="icon" type="png" href="/Caramba/public/img/Caramba-logo.png">
    <link rel="stylesheet" href="/Caramba/public/css/style.css">
    <link rel="stylesheet" href="/Caramba/public/css/responsive.css">
</head>
<body>

<?php include __DIR__ . '/navbar.php'; ?>

<div class="account-container">

    <h1>Vérification du numéro</h1>

    <div class="verify-box">

        <h3>Entrez votre numéro de téléphone</h3>
        <p class="verify-desc">
            Pour sécuriser votre compte et utiliser toutes les fonctionnalités,
            votre numéro doit être vérifié.
        </p>

        <?php if (!empty($_GET['error'])): ?>
            <div class="error-message" style="color:red; margin-bottom:10px;">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=verifnum_send">
            <div class="field">
                <label>Votre numéro</label>
                <input type="text" name="phone" placeholder="ex : 06 12 34 56 78" required>
            </div>

            <button type="submit" class="btn-verify-phone">
                Envoyer le code
            </button>
        </form>

    </div>

</div>

<?php include __DIR__ . '/footer.php'; ?>

</body>
</html>
