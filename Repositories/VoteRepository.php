<?php

namespace Repositories;

use Core\Database;

class VoteRepository
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function addVote(string $feedbackId, string $cookieHash, string $ip): bool
    {
        $sql = "
            INSERT INTO feedback_votes (feedback_id, cookie_hash, ip_address)
            VALUES (UUID_TO_BIN(?), ?, ?)
        ";
        return $this->db->query($sql, [$feedbackId, $cookieHash, $ip]);
    }

    public function countVotes(string $feedbackId): int
    {
        $sql = "
            SELECT COUNT(*) FROM feedback_votes
            WHERE feedback_id = UUID_TO_BIN(?)
        ";
        return (int) $this->db->query($sql, [$feedbackId]);
    }

    public function countActiveUsers(int $days = 30): int
    {
        $sql = "SELECT COUNT(DISTINCT ip_address) 
                FROM feedback_votes 
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)";
        return (int) $this->db->fetchColumn($sql, [$days]);
    }
}
