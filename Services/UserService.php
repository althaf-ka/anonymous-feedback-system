<?php

namespace Services;

use Repositories\UserRepository;

class UserService
{
    public function __construct(private UserRepository $userRepo) {}

    public function getHomePageData(): array
    {
        return [
            'recentSuggestions'   => $this->userRepo->getRecentSuggestions(4),
            'fulfilledSuggestions' => $this->userRepo->getFulfilledSuggestions(2),
            'totalSuggestions'    => $this->userRepo->countSuggestions(),
            'stats' => [
                'total'   => $this->userRepo->countTotalSubmissions(),
                'public'  => $this->userRepo->countPublicSuggestions(),
                'resolved' => $this->userRepo->countResolvedIssues(),
            ]
        ];
    }
}
