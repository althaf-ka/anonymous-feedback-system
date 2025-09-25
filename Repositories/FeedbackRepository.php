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

    public function deleteByIds(array $uuids): int
    {
        if (empty($uuids)) {
            return 0;
        }

        $placeholders = implode(',', array_fill(0, count($uuids), 'UUID_TO_BIN(?)'));

        $sql = "DELETE FROM feedbacks WHERE id IN ($placeholders)";

        return $this->db->query($sql, $uuids);
    }

    public function findPublicFeedbackById(string $uuid)
    {
        $sql = "SELECT 
        BIN_TO_UUID(f.id) AS id,
        f.title,
        f.message AS description,
        f.status,
        f.created_at,
        f.resolved_at,
        f.rating,
        c.name AS category_name,
        c.color AS category_color,
        (SELECT COUNT(*) FROM feedback_votes WHERE feedback_id = f.id) AS vote_count,
        fr.response AS official_response_content,
        fr.last_updated AS official_response_date,
        CASE
            WHEN TIMESTAMPDIFF(MINUTE, f.created_at, NOW()) < 60 
                THEN CONCAT(TIMESTAMPDIFF(MINUTE, f.created_at, NOW()), ' minutes ago')
            WHEN TIMESTAMPDIFF(HOUR, f.created_at, NOW()) < 24
                THEN CONCAT(TIMESTAMPDIFF(HOUR, f.created_at, NOW()), ' hours ago')
            ELSE CONCAT(TIMESTAMPDIFF(DAY, f.created_at, NOW()), ' days ago')
        END AS feedback_date,
        CASE
            WHEN fr.last_updated IS NULL THEN NULL
            WHEN TIMESTAMPDIFF(MINUTE, fr.last_updated, NOW()) < 60 
                THEN CONCAT(TIMESTAMPDIFF(MINUTE, fr.last_updated, NOW()), ' minutes ago')
            WHEN TIMESTAMPDIFF(HOUR, fr.last_updated, NOW()) < 24
                THEN CONCAT(TIMESTAMPDIFF(HOUR, fr.last_updated, NOW()), ' hours ago')
            ELSE CONCAT(TIMESTAMPDIFF(DAY, fr.last_updated, NOW()), ' days ago')
        END AS response_date
        FROM feedbacks f
        JOIN categories c ON f.category_id = c.id
        LEFT JOIN feedback_responses fr ON fr.feedback_id = f.id
        WHERE f.id = UUID_TO_BIN(?)
        AND f.allow_public = 1
        AND f.is_public = 1";


        return $this->db->fetchOne($sql, [$uuid]);
    }
    public function findAdminById(string $uuid): ?array
    {
        $sql = "SELECT 
                BIN_TO_UUID(f.id) AS id,
                f.title,
                f.message AS description,
                f.status,
                f.allow_public,
                f.is_public,
                f.created_at,
                f.resolved_at,
                f.rating,
                f.contact_details,
                c.name AS category_name,
                c.color AS category_color,
                (SELECT COUNT(*) FROM feedback_votes WHERE feedback_id = f.id) AS vote_count,
                fr.response AS official_response_content,
                fr.last_updated AS official_response_date,
                CASE
                    WHEN TIMESTAMPDIFF(MINUTE, f.created_at, NOW()) < 60 
                        THEN CONCAT(TIMESTAMPDIFF(MINUTE, f.created_at, NOW()), ' minutes ago')
                    WHEN TIMESTAMPDIFF(HOUR, f.created_at, NOW()) < 24
                        THEN CONCAT(TIMESTAMPDIFF(HOUR, f.created_at, NOW()), ' hours ago')
                    ELSE CONCAT(TIMESTAMPDIFF(DAY, f.created_at, NOW()), ' days ago')
                END AS feedback_date,
                CASE
                    WHEN fr.last_updated IS NULL THEN NULL
                    WHEN TIMESTAMPDIFF(MINUTE, fr.last_updated, NOW()) < 60 
                        THEN CONCAT(TIMESTAMPDIFF(MINUTE, fr.last_updated, NOW()), ' minutes ago')
                    WHEN TIMESTAMPDIFF(HOUR, fr.last_updated, NOW()) < 24
                        THEN CONCAT(TIMESTAMPDIFF(HOUR, fr.last_updated, NOW()), ' hours ago')
                    ELSE CONCAT(TIMESTAMPDIFF(DAY, fr.last_updated, NOW()), ' days ago')
                END AS response_date
            FROM feedbacks f
            JOIN categories c ON f.category_id = c.id
            LEFT JOIN feedback_responses fr ON fr.feedback_id = f.id
            WHERE f.id = UUID_TO_BIN(?)";

        return $this->db->fetchOne($sql, [$uuid]);
    }

    public function updatePublicVisibility(string $id, bool $isPublic): bool
    {
        return $this->db->query(
            "UPDATE feedbacks SET is_public = ? WHERE id = UUID_TO_BIN(?)",
            [$isPublic ? 1 : 0, $id]
        );
    }


    public function upsertOfficialResponse(string $feedbackId, string $content): bool
    {
        $this->db->beginTransaction();

        $exists = $this->db->fetchOne(
            "SELECT BIN_TO_UUID(id) as id FROM feedback_responses WHERE feedback_id = UUID_TO_BIN(?)",
            [$feedbackId]
        );

        if ($exists) {

            $result = $this->db->query(
                "UPDATE feedback_responses 
                 SET response = ?, last_updated = NOW() 
                 WHERE feedback_id = UUID_TO_BIN(?)",
                [$content, $feedbackId]
            );
        } else {
            $result = $this->db->query(
                "INSERT INTO feedback_responses (feedback_id, response, last_updated)
                 VALUES (UUID_TO_BIN(?), ?, NOW())",
                [$feedbackId, $content]
            );
        }

        $this->db->commit();
        return $result;
    }



    public function findPublicFiltered(array $filters, int $limit, int $offset, string $sort): array
    {

        $baseSql = "FROM feedbacks f
                LEFT JOIN categories c ON f.category_id = c.id
                LEFT JOIN feedback_votes v ON v.feedback_id = f.id
                WHERE f.is_public = 1 AND f.allow_public = 1";

        $params = [];


        if (!empty($filters['status'])) {
            $baseSql .= " AND f.status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['category'])) {
            $baseSql .= " AND c.id = UUID_TO_BIN(?)";
            $params[] = $filters['category'];
        }

        if (!empty($filters['search'])) {
            $baseSql .= " AND (f.title LIKE ? OR f.message LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }


        $countSql = "SELECT COUNT(DISTINCT f.id) " . $baseSql;
        $total = (int)$this->db->fetchColumn($countSql, $params);


        $dataSql = "SELECT
                    BIN_TO_UUID(f.id) AS id,
                    f.title,
                    f.message,
                    f.status,
                    c.name AS category,
                    c.color AS category_color,
                    f.created_at,
                    COUNT(v.id) AS votes
                " . $baseSql;

        $dataSql .= " GROUP BY f.id";

        $sortMap = [
            'recent' => 'f.created_at DESC',
            'oldest' => 'f.created_at ASC',
            'votes'  => 'votes DESC, f.created_at DESC',
            'title'  => 'f.title ASC',
        ];

        $dataSql .= " ORDER BY " . ($sortMap[$sort] ?? $sortMap['votes']);

        $dataSql .= " LIMIT ? OFFSET ?";
        $dataParams = array_merge($params, [$limit, $offset]);

        $feedbacks = $this->db->fetchAll($dataSql, $dataParams);

        return [
            'feedbacks' => $feedbacks,
            'total' => $total
        ];
    }
}
