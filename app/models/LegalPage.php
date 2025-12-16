<?php

class LegalPage
{

    public static function getBySection(string $section)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM pages_legales WHERE section = ? ORDER BY id ASC");
        $stmt->execute([$section]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function getAll()
    {
        global $pdo; 
        $stmt = $pdo->query("SELECT * FROM pages_legales ORDER BY section, id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function updateSection(int $id, string $contenu)
    {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE pages_legales SET contenu = ?, date_modif = NOW() WHERE id = ?");
        return $stmt->execute([$contenu, $id]);
    }

     public static function updateSectionFull(int $id, string $titre, string $contenu): bool
    {
        global $pdo;

        $sql = $pdo->prepare("
            UPDATE pages_legales
            SET titre = ?, contenu = ?, updated_at = NOW()
            WHERE id = ?
        ");

        return $sql->execute([$titre, $contenu, $id]);
    }
        public static function getLastUpdate(string $section)
    {
        global $pdo;

        $sql = $pdo->prepare("
            SELECT MAX(updated_at)
            FROM pages_legales
            WHERE section = ?
        ");
        $sql->execute([$section]);
        return $sql->fetchColumn();
    }
    public static function addSection(string $section, string $titre, string $contenu = "")
    {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO pages_legales (section, titre, contenu, date_modif) 
                               VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$section, $titre, $contenu]);
    }
    public static function deleteSection(int $id)
    {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM pages_legales WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
