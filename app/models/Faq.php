<?php

class Faq
{
    // Toutes les questions
    public static function getAll(): array
    {
        global $pdo;
        $sql = $pdo->query("SELECT * FROM faq ORDER BY id ASC");
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // Toutes les questions juste pour admin 
    public static function getAllDesc(): array
    {
        global $pdo;
        $sql = $pdo->query("SELECT * FROM faq ORDER BY id DESC");
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add une nouvelle question
    public static function create(string $question, string $reponse): void
    {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO faq (question, reponse) VALUES (?, ?)");
        $stmt->execute([$question, $reponse]);
    }

    // Del une question
    public static function delete(int $id): void
    {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM faq WHERE id = ?");
        $stmt->execute([$id]);
    }
}