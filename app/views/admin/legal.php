<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration - CGU & Mentions légales</title>
    <link rel="icon" type="png" href="/Caramba/public/img/Caramba-logo.png">
    <link rel="stylesheet" href="/Caramba/public/css/style.css">
    <link rel="stylesheet" href="/Caramba/public/css/responsive.css">
</head>

<body>

<?php include __DIR__ . '/../navbar.php'; ?>

<main class="admin-main">
    <h1 class="admin-title">Gestion des CGU & Mentions légales</h1>

    <div class="admin-tabs">
        <div class="admin-tab active" data-target="tab-cgu">Conditions Générales d'Utilisation</div>
        <div class="admin-tab" data-target="tab-mentions">Mentions légales</div>
    </div>

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


<!-- onglet CGU -->
<section id="tab-cgu" class="admin-section-content active">
    <h2>
        Conditions Générales d'Utilisation
        <form method="POST" style="display:inline;">
            <input type="hidden" name="action" value="add_section">
            <input type="hidden" name="section" value="cgu">
            <button type="submit" class="add-btn" title="Ajouter une section">
                <div class="add-btn-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 309.059 309.059">
                        <path fill="#fff" d="M280.71,126.181h-97.822V28.338C182.889,12.711,170.172,0,154.529,0S126.17,12.711,126.17,28.338
                            v97.843H28.359C12.722,126.181,0,138.903,0,154.529c0,15.621,12.717,28.338,28.359,28.338h97.811v97.843
                            c0,15.632,12.711,28.348,28.359,28.348c15.643,0,28.359-12.717,28.359-28.348v-97.843h97.822
                            c15.632,0,28.348-12.717,28.348-28.338C309.059,138.903,296.342,126.181,280.71,126.181z"/>
                    </svg>
                </div>
            </button>
        </form>
    </h2>

    <div id="cgu-container">
        <?php foreach ($cguSections as $cgu): ?>
            <form method="POST" class="admin-block">
                <input type="hidden" name="id" value="<?= $cgu['id'] ?>">

                <div class="block-header">
                    <input type="text" class="editable-title" name="titre" value="<?= htmlspecialchars($cgu['titre']) ?>" readonly>
                    <div class="actions">
                        <button type="button" class="edit-btn" title="Modifier le titre">
                            <svg width="20" height="20" viewBox="0 0 1024 1024" fill="#333">
                                <path d="m199.04 672.64 193.984 112 224-387.968-193.92-112-224 388.032zm-23.872 60.16 32.896 148.288 144.896-45.696L175.168 732.8zM455.04 229.248l193.92 112 56.704-98.112-193.984-112-56.64 98.112zM104.32 708.8l384-665.024 304.768 175.936L409.152 884.8h.064l-248.448 78.336L104.32 708.8zm384 254.272v-64h448v64h-448z"/>
                            </svg>
                        </button>
                        <a href="index.php?page=admin_legal&action=delete&id=<?= $cgu['id'] ?>" class="delete-btn" title="Supprimer">
                            <svg width="20" height="20" fill="#333" viewBox="0 0 24 24">
                                <path d="M9 3V4H4V6H20V4H15V3H9ZM6 7V20C6 21.1046 6.89543 22 8 22H16C17.1046 22 18 21.1046 18 20V7H6Z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <textarea name="contenu" class="admin-textarea"><?= htmlspecialchars($cgu['contenu']) ?></textarea>
                <button type="submit" class="admin-submit">Mettre à jour</button>
            </form>
        <?php endforeach; ?>
    </div>
</section>

<!-- onglet MENTIONS -->
<section id="tab-mentions" class="admin-section-content">
    <h2>
        Mentions légales
        <form method="POST" style="display:inline;">
            <input type="hidden" name="action" value="add_section">
            <input type="hidden" name="section" value="mentions">
            <button type="submit" class="add-btn" title="Ajouter une section">
                <div class="add-btn-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 309.059 309.059">
                        <path fill="#fff" d="M280.71,126.181h-97.822V28.338C182.889,12.711,170.172,0,154.529,0S126.17,12.711,126.17,28.338
                            v97.843H28.359C12.722,126.181,0,138.903,0,154.529c0,15.621,12.717,28.338,28.359,28.338h97.811v97.843
                            c0,15.632,12.711,28.348,28.359,28.348c15.643,0,28.359-12.717,28.359-28.348v-97.843h97.822
                            c15.632,0,28.348-12.717,28.348-28.338C309.059,138.903,296.342,126.181,280.71,126.181z"/>
                    </svg>
                </div>
            </button>
        </form>
    </h2>

    <div id="mentions-container">
        <?php foreach ($mentionSections as $m): ?>
            <form method="POST" class="admin-block">
                <input type="hidden" name="id" value="<?= $m['id'] ?>">

                <div class="block-header">
                    <input type="text" class="editable-title" name="titre" value="<?= htmlspecialchars($m['titre']) ?>" readonly>
                    <div class="actions">
                       
                        <button type="button" class="edit-btn" title="Modifier le titre">
                            <svg width="20" height="20" viewBox="0 0 1024 1024" fill="#333">
                                <path d="m199.04 672.64 193.984 112 224-387.968-193.92-112-224 388.032zm-23.872 60.16 32.896 148.288 144.896-45.696L175.168 732.8zM455.04 229.248l193.92 112 56.704-98.112-193.984-112-56.64 98.112zM104.32 708.8l384-665.024 304.768 175.936L409.152 884.8h.064l-248.448 78.336L104.32 708.8zm384 254.272v-64h448v64h-448z"/>
                            </svg>
                        </button>

                     
                        <a href="index.php?page=admin_legal&action=delete&id=<?= $m['id'] ?>" class="delete-btn" title="Supprimer">
                            <svg width="20" height="20" fill="#333" viewBox="0 0 24 24">
                                <path d="M9 3V4H4V6H20V4H15V3H9ZM6 7V20C6 21.1046 6.89543 22 8 22H16C17.1046 22 18 21.1046 18 20V7H6Z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <textarea name="contenu" class="admin-textarea"><?= htmlspecialchars($m['contenu']) ?></textarea>
                <button type="submit" class="admin-submit">Mettre à jour</button>
            </form>
        <?php endforeach; ?>
    </div>
</section>

</main>

<!-- MODALE DE CONFIRMATION SUPPRESSION -->
<div id="confirmModal" class="confirm-modal">
  <div class="confirm-content">
    <h3>Confirmation</h3>
    <p>Voulez-vous vraiment supprimer cette section ?</p>
    <div class="confirm-actions">
      <button id="confirmYes" class="btn-confirm-yes">Oui, supprimer</button>
      <button id="confirmNo" class="btn-confirm-no">Annuler</button>
    </div>
  </div>
</div>

<script src="/Caramba/public/js/deleteConfirm.js"></script>
<script src="/Caramba/public/js/adminTabs.js"></script>
<script src="/Caramba/public/js/editableTitle.js"></script>
<script src="/Caramba/public/js/preventCache.js"></script>
<script src="/Caramba/public/js/flashMessages.js"></script>


<?php include __DIR__ . '/../footer.php'; ?>

</body>
</html>
