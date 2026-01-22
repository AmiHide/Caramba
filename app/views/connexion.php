<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Caramba</title>
    <link rel="icon" type="png" href="/Caramba/public/img/Caramba-logo.png">
    <link rel="stylesheet" href="/Caramba/public/css/style.css">
    <link rel="stylesheet" href="/Caramba/public/css/responsive.css">
</head>

<body>

<?php include __DIR__ . '/navbar.php'; ?>

<div class="connexion-bg">
    <form class="connexion-box" method="POST" action="index.php?page=connexion">
        <h2>Connexion</h2>

<?php if (!empty($message)): ?>
    <div class="login-error"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>


        <div class="floating-group">
            <input type="email" name="email" placeholder=" " required>
            <label>Email</label>
        </div>

        <div class="floating-group">
            <input type="password" name="password" placeholder=" " required>
            <label>Mot de passe</label>
        </div>

        <div class="forgot-wrapper">
            <a href="index.php?page=forgot" class="forgot-left">Mot de passe oublié ?</a>
        </div>

        <div class="links">
            <p>Pas encore membre ? <a href="index.php?page=register">Inscrivez-vous</a></p>
        </div>

        <button type="submit" class="submit-btn">Se connecter</button>
    </form>

</div>

<?php include __DIR__ . '/footer.php'; ?>

<script src="/Caramba/public/js/preventCache.js"></script>

</body>
</html>
