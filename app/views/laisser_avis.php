<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laisser un avis</title>
<link rel="icon" type="png" href="/Caramba/public/img/Caramba-logo.png">
<link rel="stylesheet" href="/Caramba/public/css/style.css">
<link rel="stylesheet" href="/Caramba/public/css/responsive.css">
</head>

<body>
<?php include __DIR__ . '/navbar.php'; ?>

<div class="form-container">
    <?php
        $parts = explode(' ', trim($cible['nom']));
        $prenom = ucfirst(strtolower($parts[0]));
        $nomFamille = isset($parts[1]) ? strtoupper($parts[1]) : "";
    ?>

    <h2>Laisser un avis sur <?= htmlspecialchars($prenom . " " . $nomFamille) ?></h2>

    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Note :</label>
        <div class="rating">
            <input type="radio" name="note" value="5" id="star5"><label for="star5">★</label>
            <input type="radio" name="note" value="4" id="star4"><label for="star4">★</label>
            <input type="radio" name="note" value="3" id="star3"><label for="star3">★</label>
            <input type="radio" name="note" value="2" id="star2"><label for="star2">★</label>
            <input type="radio" name="note" value="1" id="star1"><label for="star1">★</label>
        </div>

        <label>Commentaire :</label>
        <textarea name="commentaire" placeholder="Votre avis..." required></textarea>

        <button type="submit" class="submit-btn">Envoyer l'avis</button>
    </form>
</div>

<?php include __DIR__ . '/footer.php'; ?>

<script src="/Caramba/public/js/preventCache.js"></script>
</body>
</html>