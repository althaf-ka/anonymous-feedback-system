<?php

namespace Services;

use Repositories\VoteRepository;
use Exception;
use mysqli_sql_exception; // Import the MySQLi exception class

class VoteService
{
    public function __construct(private VoteRepository $voteRepo) {}

    public function castVote(string $feedbackId, string $cookieValue, string $ipAddress): int
    {
        $cookieHash = hash('sha256', $cookieValue);

        try {

            $this->voteRepo->addVote($feedbackId, $cookieHash, $ipAddress);
        } catch (mysqli_sql_exception $e) {

            // Error code 1062 is "Duplicate entry" for a UNIQUE key.
            if ($e->getCode() === 1062) {
                throw new Exception("You have already voted on this item.");
            }
            throw $e;
        }


        return $this->voteRepo->countVotes($feedbackId);
    }

    public function getVoteCount(string $feedbackId): int
    {
        return $this->voteRepo->countVotes($feedbackId);
    }
}
