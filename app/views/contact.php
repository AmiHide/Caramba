<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Caramba</title>
    <link rel="icon" type="png" href="/Caramba/public/img/Caramba-logo.png">
    <link rel="stylesheet" href="/Caramba/public/css/style.css">
    <link rel="stylesheet" href="/Caramba/public/css/responsive.css">
</head>

<body>
<div id="toast" class="toast hidden"></div>

<?php include __DIR__ . '/navbar.php'; ?>

<section class="contact-header">
    <h1>Besoin d’aide ? Écrivez-nous !</h1>
</section>

<main class="contact-container">
    <div class="contact-message hidden"></div>

    <form id="contactForm" class="contact-form" method="POST">
        <div class="form-row">
            <div class="form-group">
                <label>Nom *</label>
                <input type="text" name="nom" placeholder="Nom" required>
            </div>

            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" placeholder="Email@domain.com" required>
            </div>
        </div>

        <div class="form-group full">
            <label>Message *</label>
            <textarea name="message" placeholder="Votre message" required></textarea>
        </div>

        <button type="submit" class="btn-submit">Envoyer</button>
    </form>
</main>

<?php include __DIR__ . '/footer.php'; ?>

<script src="/Caramba/public/js/contactForm.js"></script>
<script src="/Caramba/public/js/preventCache.js"></script>

</body>
</html>
