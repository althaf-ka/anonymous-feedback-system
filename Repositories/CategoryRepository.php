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
            "SELECT BIN_TO_UUID(id) AS id 
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

    public function findAll(): array
    {
        return $this->db->fetchAll("SELECT * FROM categories ORDER BY name ASC");
    }
}
