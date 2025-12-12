<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier mon e-mail</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>


<?php include __DIR__ . '/navbar.php'; ?>

<div class="connexion-bg">
    <form class="connexion-box" method="POST">
        <h2>Modifier mon adresse e-mail</h2>

        <?php if (!empty($success)) echo $success; ?>
        <?php if (!empty($error)) echo "<p style='color:red'>$error</p>"; ?>

        <label>Votre adresse e-mail actuelle</label>
        <input type="email" name="email" required placeholder="email@exemple.com">

        <button type="submit" class="submit-btn">Envoyer le lien</button>
    </form>
</div>

<?php include __DIR__ . '/footer.php'; ?>
