<?php

namespace Controllers;

use Core\Response;
use Core\Validator;
use Exception;
use Services\VoteService;

class VoteController
{
    private VoteService $voteService;

    public function __construct(VoteService $voteService)
    {
        $this->voteService = $voteService;
    }

    public function castVote()
    {
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            Response::error('Something went wrong please try again !', [], 403);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        Validator::require(["feedbackId"], $input);

        $feedbackId = $input['feedbackId'] ?? null;

        $cookieName = "visitor_id";
        $cookieValue = $_COOKIE[$cookieName] ?? bin2hex(random_bytes(16));
        setcookie($cookieName, $cookieValue, ['expires' => time() + 31536000, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax']);

        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

        try {
            $voteCount = $this->voteService->castVote($feedbackId, $cookieValue, $ipAddress);

            Response::success("Vote cast successfully.", [
                'voteCount' => $voteCount
            ]);
        } catch (Exception $e) {
            error_log(print_r($feedbackId, true));
            $currentVoteCount = $this->voteService->getVoteCount($feedbackId);

            Response::error($e->getMessage(), [
                'voteCount' => $currentVoteCount
            ], 409);
        }
    }
}
