<?php

namespace Repositories;

use Core\Database;

class CategoryRepository
{
    private Database $db;

    public function __construct(Database $database)
    {
        $this->db = $database;
    }

    public function insert(string $name, string $color): string | null
    {
        $this->db->query(
            "INSERT INTO categories (name, color) VALUES (?, ?)",
            [$name, $color]
        );

        $uuid = $this->db->fetchColumn(
            "SELECT id 
             FROM categories 
             WHERE name = ? AND color = ? 
             ORDER BY id DESC 
             LIMIT 1",
            [$name, $color]
        );

        return $uuid ?? null;
    }

    public function isCategoryExists(string $name)
    {
        return $this->db->fetchColumn(
            "SELECT COUNT(*) FROM categories WHERE name = ?",
            [$name]
        );
    }

    public function isColorExists(string $color)
    {
        return $this->db->fetchColumn(
            "SELECT COUNT(*) FROM categories WHERE color = ?",
            [$color]
        );
    }

    public function findAll(array $columns = ['*']): array
    {
        $colsString = implode(', ', $columns);
        return $this->db->fetchAll("SELECT $colsString FROM categories ORDER BY name ASC");
    }

    public function deleteById(string $id): bool
    {
        $sql = "DELETE FROM categories WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }

    public function findAllWithFeedbackCount(int $limit = 20, int $offset = 0): array
    {
        return $this->db->fetchAll(
            "SELECT 
                c.id,
                c.name,
                c.color,
                COUNT(f.id) AS feedbacks
             FROM categories c
             LEFT JOIN feedbacks f ON f.category_id = c.id
             GROUP BY c.id
             ORDER BY c.name ASC
             LIMIT ? OFFSET ?",
            [$limit, $offset]
        );
    }

    public function countAll(): int
    {
        return (int) $this->db->fetchColumn(
            "SELECT COUNT(*) FROM categories"
        );
    }

    public function getTopCategories(int $limit = 4): array
    {
        $sql = "SELECT 
                c.name, 
                c.color, 
                COUNT(f.id) AS feedback_count
            FROM categories c
            JOIN feedbacks f ON c.id = f.category_id
            GROUP BY c.id, c.name, c.color
            ORDER BY feedback_count DESC
            LIMIT ?
        ";
        return $this->db->fetchAll($sql, [$limit]);
    }
}
