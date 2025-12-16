<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caramba - Mon compte</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
    require_once 'config/db.php';
    
    $user_id = 1;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        die("Utilisateur non trouvé");
    }
    ?>

    <header>
        <!-- ... tout le HTML du header ... -->
    </header>

    <main>
        <!-- ... tout le HTML du main ... -->
    </main>

    <!-- Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h4 id="modalTitle">Modifier</h4>
            <input type="hidden" id="editField">
            <input type="text" id="editValue" placeholder="Nouvelle valeur">
            <div class="modal-buttons">
                <button class="btn-cancel" onclick="closeModal()">Annuler</button>
                <button class="btn-save" onclick="saveField()">Enregistrer</button>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>