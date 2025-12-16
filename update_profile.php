<?php
require_once 'config/db.php';
header('Content-Type: application/json');

$field = $_POST['field'] ?? '';
$value = $_POST['value'] ?? '';
$user_id = $_POST['user_id'] ?? 1; // ID de l'utilisateur de test

if ($field && $value) {
    // Liste des champs autorisés pour la mise à jour (Sécurité !)
    $allowed_fields = ['nom', 'email', 'description', 'type_voiture', 'type_permis', 'a_permis'];

    if (in_array($field, $allowed_fields)) {
        try {
            // Requête préparée pour éviter les injections SQL
            $sql = "UPDATE users SET $field = :value WHERE id = :user_id";
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':value', $value);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            echo json_encode(['success' => true]);
        } catch(PDOException $e) {
            // Afficher l'erreur pour le débogage
            // echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            echo json_encode(['success' => false]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Champ non autorisé']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Données manquantes']);
}
?>