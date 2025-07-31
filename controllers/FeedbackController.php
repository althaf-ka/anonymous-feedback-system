<?php

namespace controllers;

use services\FeedbackService;

class FeedbackController
{
    public function show($id)
    {
        // $feedback = FeedbackService::find($id);

        // if (!$feedback) {
        //     http_response_code(404);
        //     require __DIR__ . '/../views/errors/404.php';
        //     return;
        // }

        require __DIR__ . '/../views/user/feedback-details.php';
    }
}
