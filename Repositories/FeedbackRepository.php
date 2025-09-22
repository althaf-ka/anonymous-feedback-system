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

    public function findFiltered(array $filters, int $limit, int $offset, string $sort): array
    {

        $baseSql = "FROM feedbacks f
                LEFT JOIN categories c ON f.category_id = c.id
                LEFT JOIN feedback_votes v ON v.feedback_id = f.id
                WHERE 1=1";

        $params = [];

        if (!empty($filters['status'])) {
            $baseSql .= " AND f.status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['category'])) {
            $baseSql .= " AND f.category_id = UUID_TO_BIN(?)";
            $params[] = $filters['category'];
        }

        if (!empty($filters['search'])) {
            $baseSql .= " AND f.title LIKE ?";
            $params[] = '%' . $filters['search'] . '%';
        }

        $countSql = "SELECT COUNT(DISTINCT f.id) " . $baseSql;
        $total = (int)$this->db->fetchColumn($countSql, $params);


        $dataSql = "SELECT 
                    BIN_TO_UUID(f.id) AS id,
                    f.title,
                    c.name AS cat,
                    f.status,
                    COUNT(v.id) AS votes,
                    f.allow_public,
                    f.created_at " . $baseSql;

        $dataSql .= " GROUP BY f.id";

        $sortMap = [
            'recent' => 'f.created_at DESC',
            'oldest' => 'f.created_at ASC',
            'votes'  => 'votes DESC',
            'title'  => 'f.title ASC',
        ];
        $dataSql .= " ORDER BY " . ($sortMap[$sort] ?? $sortMap['recent']);

        $dataSql .= " LIMIT ? OFFSET ?";
        $dataParams = array_merge($params, [$limit, $offset]);

        $feedbacks = $this->db->fetchAll($dataSql, $dataParams);

        // --- 4. Return the new, combined structure ---
        return [
            'feedbacks' => $feedbacks,
            'total' => $total
        ];
    }

    public function updateStatus(string $id, string $status): bool
    {
        return $this->db->query(
            "UPDATE feedbacks 
         SET status = ? 
         WHERE id = UUID_TO_BIN(?)",
            [$status, $id]
        );
    }
}
