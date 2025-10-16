<?php

namespace Repositories;

use Core\Database;
use Models\Admin;

class AdminRepository
{
    private Database $db;

    public function __construct(Database $database)
    {
        $this->db = $database;
    }

    public function findByEmail(string $email): ?Admin
    {
        $row = $this->db->fetchOne("SELECT * from admins WHERE email = ?", [$email]);
        return $row ? new Admin($row) : null;
    }

    public function create(string $email, string $password): void
    {
        $this->db->query(
            "INSERT INTO admins (email, password) VALUES (?, ?)",
            [$email, $password]
        );
    }

    public function getAllForExport(): array
    {
        $sql = "SELECT 
            f.id AS id,
            f.title,
            f.message,
            f.status,
            c.name AS category,
            f.allow_public,
            f.is_public,
            f.contact_details,
            f.rating,
            f.created_at,
            COUNT(v.id) AS votes  
        FROM feedbacks f
        LEFT JOIN categories c ON f.category_id = c.id
        LEFT JOIN feedback_votes v ON v.feedback_id = f.id
        GROUP BY f.id, c.name 
        ORDER BY f.created_at DESC
        ";
        return $this->db->fetchAll($sql, []);
    }
}
