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
             VALUES (?, ?, ?, ?, ?, ?)",
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
            $baseSql .= " AND f.category_id = ?";
            $params[] = $filters['category'];
        }

        if (!empty($filters['search'])) {
            $baseSql .= " AND f.title LIKE ?";
            $params[] = '%' . $filters['search'] . '%';
        }

        $countSql = "SELECT COUNT(DISTINCT f.id) " . $baseSql;
        $total = (int)$this->db->fetchColumn($countSql, $params);

        $dataSql = "SELECT 
                    f.id AS id,
                    f.title,
                    c.name AS cat,
                    f.status,
                    COUNT(v.id) AS votes,
                    f.allow_public,
                    f.created_at " . $baseSql;

        $dataSql .= " GROUP BY f.id, c.name";

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

        return ['feedbacks' => $feedbacks, 'total' => $total];
    }

    public function updateStatus(string $id, string $status): bool
    {
        $sql = "
        UPDATE feedbacks 
            SET status = ?, resolved_at = CASE WHEN ? = 'resolved' THEN NOW() ELSE NULL END
            WHERE id = ?
        ";

        return $this->db->query($sql, [$status, $status, $id]);
    }

    public function deleteByIds(array $uuids): int
    {
        if (empty($uuids)) {
            return 0;
        }

        $placeholders = implode(',', array_fill(0, count($uuids), '?'));
        $sql = "DELETE FROM feedbacks WHERE id IN ($placeholders)";

        $this->db->query($sql, $uuids);
        $affectedRows = $this->db->getAffectedRows();

        return $affectedRows;
    }

    public function findPublicFeedbackById(string $uuid)
    {
        $sql = "SELECT 
        f.id AS id,
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
        WHERE f.id = ?
        AND f.allow_public = 1
        AND f.is_public = 1";


        return $this->db->fetchOne($sql, [$uuid]);
    }
    public function findAdminById(string $uuid): ?array
    {
        $sql = "SELECT 
                f.id AS id,
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
            WHERE f.id = ?";

        return $this->db->fetchOne($sql, [$uuid]);
    }

    public function updatePublicVisibility(string $id, bool $isPublic): bool
    {
        return $this->db->query(
            "UPDATE feedbacks SET is_public = ? WHERE id = ?",
            [$isPublic ? 1 : 0, $id]
        );
    }


    public function upsertOfficialResponse(string $feedbackId, string $content): bool
    {
        $this->db->beginTransaction();

        $exists = $this->db->fetchOne(
            "SELECT id as id FROM feedback_responses WHERE feedback_id = ?",
            [$feedbackId]
        );

        if ($exists) {
            $result = $this->db->query(
                "UPDATE feedback_responses 
                 SET response = ?, last_updated = NOW() 
                 WHERE feedback_id = ?",
                [$content, $feedbackId]
            );
        } else {
            $result = $this->db->query(
                "INSERT INTO feedback_responses (feedback_id, response, last_updated)
                 VALUES (?, ?, NOW())",
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
            $baseSql .= " AND c.id = ?";
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
                    f.id AS id,
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

    public function countTotalFeedback(): int
    {
        return (int) $this->db->fetchColumn("SELECT COUNT(id) FROM feedbacks");
    }

    public function countPendingFeedback(): int
    {
        return (int) $this->db->fetchColumn("SELECT COUNT(id) FROM feedbacks WHERE status = 'new' OR status = 'review'");
    }

    public function countFeedbackByStatus(string $status): int
    {
        return (int) $this->db->fetchColumn("SELECT COUNT(id) FROM feedbacks WHERE status = ?", [$status]);
    }

    public function getRecentFeedbackActivity(int $limit = 5): array
    {
        $sql = "SELECT 
                f.title, 
                f.created_at,
                c.name AS category_name
            FROM feedbacks f
            LEFT JOIN categories c ON f.category_id = c.id
            ORDER BY f.created_at DESC
            LIMIT ?
        ";
        return $this->db->fetchAll($sql, [$limit]);
    }
}
