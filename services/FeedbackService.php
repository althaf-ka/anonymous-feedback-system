<?php
namespace services;

use models\Feedback;

class FeedbackService
{
    public static function find($id)
    {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM feedback WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        return $data ? new Feedback($data) : null;
    }
}
