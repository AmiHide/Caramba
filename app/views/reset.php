<!DOCTYPE html>
<html lang='fr'>
<head>
<meta charset='UTF-8'>
<title>Réinitialiser mot de passe</title>
<link rel='stylesheet' href='css/style.css'>
</head>
<body>

<?php include __DIR__ . '/navbar.php'; ?>

<div class='connexion-bg'>
<form class='connexion-box' method='POST'>
    <h2>Nouveau mot de passe</h2>

    <?= $message ?>

    <label>Nouveau mot de passe</label>
    <input type='password' name='p1' required>

    <label>Confirmez le mot de passe</label>
    <input type='password' name='p2' required>

    <button class='submit-btn'>Réinitialiser</button>
</form>
</div>

<?php include __DIR__ . '/footer.php'; ?>

</body>
</html>