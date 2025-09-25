<?php

namespace Repositories;

use Core\Database;

class UserRepository
{
    private Database $db;

    public function __construct(Database $database)
    {
        $this->db = $database;
    }

    public function getRecentSuggestions(int $limit = 10): array
    {
        return $this->db->fetchAll(
            "SELECT 
            BIN_TO_UUID(f.id) AS id,
            c.name AS category,
            c.color AS category_color,
            f.title,
            f.message,
            f.status,
            CASE
                WHEN TIMESTAMPDIFF(MINUTE, f.created_at, NOW()) < 60 
                THEN CONCAT(TIMESTAMPDIFF(MINUTE, f.created_at, NOW()), ' minutes ago')
                
                WHEN TIMESTAMPDIFF(HOUR, f.created_at, NOW()) < 24
                THEN CONCAT(TIMESTAMPDIFF(HOUR, f.created_at, NOW()), ' hours ago')
                
                ELSE CONCAT(TIMESTAMPDIFF(DAY, f.created_at, NOW()), ' days ago')
            END AS created_at,
            COUNT(v.id) AS votes
        FROM feedbacks f
        JOIN categories c ON f.category_id = c.id
        LEFT JOIN feedback_votes v ON v.feedback_id = f.id
        WHERE f.is_public = 1 AND f.status != 'resolved' AND f.allow_public = 1
        GROUP BY f.id
        ORDER BY f.created_at DESC
        LIMIT ?",
            [$limit]
        );
    }

    public function getFulfilledSuggestions(int $limit = 5): array
    {
        return $this->db->fetchAll(
            "SELECT 
                BIN_TO_UUID(f.id) AS id,
                c.name AS category,
                c.color AS category_color,
                f.title,
                f.message AS preview,
                f.status,
                CASE
                    WHEN TIMESTAMPDIFF(MINUTE, f.created_at, NOW()) < 60 
                    THEN CONCAT(TIMESTAMPDIFF(MINUTE, f.created_at, NOW()), ' minutes ago')
                
                    WHEN TIMESTAMPDIFF(HOUR, f.created_at, NOW()) < 24
                    THEN CONCAT(TIMESTAMPDIFF(HOUR, f.created_at, NOW()), ' hours ago')
                
                    ELSE CONCAT(TIMESTAMPDIFF(DAY, f.created_at, NOW()), ' days ago')
                END AS created_at
            FROM feedbacks f
            JOIN categories c ON f.category_id = c.id
            LEFT JOIN feedback_votes v ON v.feedback_id = f.id
            WHERE f.is_public = 1 AND f.status = 'resolved'
            GROUP BY f.id
            ORDER BY f.resolved_at DESC
            LIMIT ?",
            [$limit]
        );
    }

    public function countSuggestions(): int
    {
        return (int) $this->db->fetchColumn(
            "SELECT COUNT(*) FROM feedbacks WHERE is_public = 1 AND status != 'resolved'"
        );
    }

    public function countTotalSubmissions(): int
    {
        return (int) $this->db->fetchColumn(
            "SELECT COUNT(*) FROM feedbacks"
        );
    }

    public function countPublicSuggestions(): int
    {
        return (int) $this->db->fetchColumn(
            "SELECT COUNT(*) FROM feedbacks WHERE is_public = 1"
        );
    }

    public function countResolvedIssues(): int
    {
        return (int) $this->db->fetchColumn(
            "SELECT COUNT(*) FROM feedbacks WHERE status = 'resolved'"
        );
    }
}
