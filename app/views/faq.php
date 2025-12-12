<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>FAQ - Caramba</title>
    <link rel="stylesheet" href="public/css/style.css">
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

<script src="public/js/faqToggle.js"></script>
<script src="public/js/preventCache.js"></script>
</body>
</html>