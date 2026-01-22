<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="icon" type="png" href="/Caramba/public/img/Caramba-logo.png">
    <link rel="stylesheet" href="/Caramba/public/css/style.css">
    <link rel="stylesheet" href="/Caramba/public/css/responsive.css">
</head>
<body>

<?php include __DIR__ . '/navbar.php'; ?>

<div class="connexion-bg">
    <form class="connexion-box" method="POST">
        <h2>Réinitialisation du mot de passe</h2>

        <?php if (!empty($message)) : ?>
            <p><?= $message ?></p>
        <?php endif; ?>

        <label>Email :</label>
        <input type="email" name="email" placeholder="email@exemple.com" required>

        <button type="submit" class="submit-btn">Envoyer</button>
    </form>
</div>

<?php include __DIR__ . '/footer.php'; ?>

<script src="/Caramba/public/js/preventCache.js"></script>

</body>
</html>
