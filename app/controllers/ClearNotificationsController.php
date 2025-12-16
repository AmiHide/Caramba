<?php

class ClearNotificationsController
{
    public function index()
    {
        if (!isset($_SESSION['user']['id'])) exit;

        $userId = $_SESSION['user']['id'];
        
        // Effacer TOUS les messages, pas seulement "lu"
        global $pdo;
        $pdo->prepare("DELETE FROM notifications WHERE user_id = ?")->execute([$userId]);

        echo "OK";
        exit;
    }
}

