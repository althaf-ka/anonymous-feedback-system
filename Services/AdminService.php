<?php

namespace Services;

use Repositories\AdminRepository;
use Repositories\FeedbackRepository;
use Repositories\CategoryRepository;
use Repositories\VoteRepository;

class AdminService
{
    public function __construct(
        private FeedbackRepository $feedbackRepo,
        private CategoryRepository $categoryRepo,
        private VoteRepository     $voteRepo,
        private AdminRepository    $adminRepo
    ) {}

    public function getDashboardData(): array
    {
        $totalFeedback = $this->feedbackRepo->countTotalFeedback();
        $pendingFeedback = $this->feedbackRepo->countPendingFeedback();
        $resolvedFeedback = $this->feedbackRepo->countFeedbackByStatus('resolved');
        $resolutionRate = ($totalFeedback > 0) ? ($resolvedFeedback / $totalFeedback) * 100 : 0;

        return [
            'metrics' => [
                'totalFeedback'    => $totalFeedback,
                'pendingFeedback'  => $pendingFeedback,
                'resolvedFeedback' => $resolvedFeedback,
                'resolutionRate'   => $resolutionRate,
                'activeUsers'      => $this->voteRepo->countActiveUsers(30),
            ],
            'quickActions' => [
                'pendingCount'  => $pendingFeedback,
                'newCount'      => $this->feedbackRepo->countFeedbackByStatus('new'),
                'categoryCount' => $this->categoryRepo->countAll(),
            ],
            'recentActivity'    => $this->feedbackRepo->getRecentFeedbackActivity(3),
            'categoryAnalytics' => $this->categoryRepo->getTopCategories(5),
        ];
    }
    public function getFeedbackForExport(): array
    {
        return $this->adminRepo->getAllForExport();
    }
}
