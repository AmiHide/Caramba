<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Caramba</title>
    <link rel="icon" type="png" href="/Caramba/public/img/Caramba-logo.png">
    <link rel="stylesheet" href="/Caramba/public/css/style.css">
    <link rel="stylesheet" href="/Caramba/public/css/responsive.css">
</head>
<body>

<?php include __DIR__ . '/navbar.php'; ?>

<section class="faq-header">
    <h1>FAQ - Questions fréquentes</h1>
</section>

<main class="faq-container">
    <?php foreach ($faqs as $f): ?>
        <div class="faq-accordion">
            <button class="faq-question">
                <span><?= htmlspecialchars($f['question']) ?></span>
                <span class="arrow">▾</span>
            </button>
            <div class="faq-answer">
                <p><?= nl2br(htmlspecialchars($f['reponse'])) ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</main>

<?php include __DIR__ . '/footer.php'; ?>

<script src="/Caramba/public/js/faqToggle.js"></script>
<script src="/Caramba/public/js/preventCache.js"></script>
</body>
</html>