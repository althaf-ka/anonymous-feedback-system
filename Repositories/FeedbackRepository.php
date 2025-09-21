<?php

namespace Repositories;

use Core\Database;

class FeedbackRepository
{
    private Database $db;

    public function __construct(Database $database)
    {
        $this->db = $database;
    }

    public function insert(array $data): bool
    {
        return $this->db->query(
            "INSERT INTO feedbacks (title, message, category_id, allow_public, rating, contact_details) 
             VALUES (?, ?, UUID_TO_BIN(?), ?, ?, ?)",
            [
                $data['title'],
                $data['message'],
                $data['category_id'],
                $data['allow_public'],
                $data['rating'],
                $data['contact_details'] ?? null
            ]
        );
    }
}
