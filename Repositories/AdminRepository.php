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
}
