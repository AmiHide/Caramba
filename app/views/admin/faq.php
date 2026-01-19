<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration FAQ - Caramba</title>
    <link rel="icon" type="png" href="/Caramba/public/img/Caramba-logo.png">
    <link rel="stylesheet" href="/Caramba/public/css/style.css">
    <link rel="stylesheet" href="/Caramba/public/css/responsive.css">
</head>
<body>

<?php include __DIR__ . '/../navbar.php'; ?>

<main class="admin-main">
    <h1 class="admin-title">Gestion de la FAQ</h1>

    <?php if (!empty($_SESSION["flash_success"])): ?>
        <div class="flash-success flash-msg">
            <?= $_SESSION["flash_success"]; unset($_SESSION["flash_success"]); ?>
            <span class="close-flash">&times;</span>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION["flash_error"])): ?>
        <div class="flash-error flash-msg">
            <?= $_SESSION["flash_error"]; unset($_SESSION["flash_error"]); ?>
            <span class="close-flash">&times;</span>
        </div>
    <?php endif; ?>

    <!-- Bloc ajout -->
    <section class="admin-block">
        <h2>Ajouter une question</h2>
        <form method="POST" class="admin-form">
            <label>Question</label>
            <textarea name="question" required></textarea>
            <label>Réponse</label>
            <textarea name="reponse" required></textarea>
            <button type="submit" class="btn-admin-primary">Ajouter</button>
        </form>
    </section>

    <!-- Bloc liste -->
    <section class="admin-block">
        <h2>Questions existantes</h2>

        <?php if (empty($faq)): ?>
            <p>Aucune question pour l’instant.</p>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Question</th>
                    <th>Réponse</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($faq as $f): ?>
                    <tr>
                        <td><?= $f["id"] ?></td>
                        <td><?= htmlspecialchars($f["question"]) ?></td>
                        <td><?= nl2br(htmlspecialchars($f["reponse"])) ?></td>
                        <td>
                            <a class="btn-admin-danger"
                               href="index.php?page=admin_faq&delete=<?= $f["id"] ?>"
                               onclick="return confirm('Supprimer cette question ?');">
                                Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
</main>

<?php include __DIR__ . '/../footer.php'; ?>

<script src="/Caramba/public/js/flashMessages.js"></script>

<script src="/Caramba/public/js/preventCache.js"></script>

</body>
</html>