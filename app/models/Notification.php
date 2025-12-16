<?php

class Notification
{
    public static function add(int $userId, string $message): void
    {
        global $pdo;

        $sql = $pdo->prepare("
            INSERT INTO notifications (user_id, message, is_read, created_at)
            VALUES (?, ?, 0, NOW())
        ");
        $sql->execute([$userId, $message]);
    }

    public static function getUnreadCount(int $userId): int
    {
        global $pdo;

        $sql = $pdo->prepare("
            SELECT COUNT(*) FROM notifications
            WHERE user_id = ? AND is_read = 0
        ");
        $sql->execute([$userId]);

        return (int) $sql->fetchColumn();
    }

    public static function getAllUnread(int $userId): array
    {
        global $pdo;

        $sql = $pdo->prepare("
            SELECT * FROM notifications
            WHERE user_id = ? AND is_read = 0
            ORDER BY created_at DESC
        ");
        $sql->execute([$userId]);

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function markAllRead(int $userId): void
    {
        global $pdo;

        $sql = $pdo->prepare("
            UPDATE notifications
            SET is_read = 1
            WHERE user_id = ?
        ");
        $sql->execute([$userId]);
    }
}


