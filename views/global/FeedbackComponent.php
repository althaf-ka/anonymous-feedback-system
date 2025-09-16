<?php

namespace views\global;

require_once __DIR__ . "/../admin/components/status-selector.php";

class FeedbackComponent
{
    private array $data;
    private bool $isAdmin;

    public function __construct(array $data, bool $isAdmin = false)
    {
        $this->data = $data;
        $this->isAdmin = $isAdmin;
    }

    public function render(): string
    {
        ob_start();
        $d = $this->data;

        // Safe defaults
        $title       = $d['title'] ?? "Feedback System";
        $category    = $d['category'] ?? "";
        $status      = $d['status'];
        $timeAgo     = $d['timeAgo'] ?? "Just now";
        $description = $d['description'] ?? "";
        $voteCount   = $d['voteCount'] ?? 0;
        $feedbackId  = $d['feedbackId'] ?? 0;
        $userOptedPublic = $d["allow-public"];
        $isPublic    = $d['is-public'] ?? false;
        $contact     = $d['contact'] ?? null;
        $rating      = $d['rating'] ?? 0;
?>

        <!-- Header -->
        <section class="feedback-header">
            <div class="container">
                <h1 class="section-title"><?= htmlspecialchars($title) ?></h1>
                <div class="feedback-meta">
                    <span class="meta-item rounded-sm category-indicator <?= strtolower($category) ?>">
                        <?= htmlspecialchars($category) ?>
                    </span>
                    <span class="rounded-sm status-<?= strtolower($status) ?> meta-item status-element">
                        <?= htmlspecialchars(ucwords($status)) ?>
                    </span>
                    <span class="meta-item rounded-sm">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>
                        <?= htmlspecialchars($timeAgo) ?>
                    </span>
                </div>
            </div>
        </section>

        <!-- Content -->
        <section class="feedback-content">
            <div class="container">
                <div class="content-layout">
                    <!-- Main -->
                    <div class="main-content">
                        <!-- Description -->
                        <div class="content-card rounded-sm">
                            <div class="card-header">
                                <h2 class="card-title">Feedback Description</h2>
                            </div>
                            <div class="card-content">
                                <div class="description-text">
                                    <?= $this->renderFormatedParagraph($description) ?>
                                </div>
                            </div>
                        </div>

                        <!-- Official Response -->
                        <?php if ($d['allow-public']): ?>
                            <div class="content-card official-response rounded-sm">
                                <div class="card-header">
                                    <div class="official-badge">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                        </svg>
                                        Official Response
                                    </div>
                                    <?php if (!empty($d['official_response']['date'])): ?>
                                        <span class="response-date">
                                            <?= htmlspecialchars(date("M j, Y g:i A", strtotime($d['official_response']['date']))) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <div class="card-content">
                                    <?php if ($this->isAdmin): ?>
                                        <?php $responseContent = trim($d['official_response']['content'] ?? ""); ?>

                                        <!-- VIEW MODE -->
                                        <div id="official-response-view" <?= $responseContent !== "" ? '' : '' ?>>
                                            <?php if ($responseContent !== ""): ?>
                                                <p><?= nl2br(htmlspecialchars($responseContent)) ?></p>
                                                <button class="btn btn-sm btn-warning" onclick="toggleResponseForm(true)">Edit Response</button>
                                            <?php else: ?>
                                                <p class="no-response">No official response has been added yet.</p>
                                                <button class="btn btn-sm btn-primary" onclick="toggleResponseForm(true)">Add Response</button>
                                            <?php endif; ?>
                                        </div>

                                        <!-- FORM MODE -->
                                        <div id="official-response-form" style="display:none">
                                            <form id="official-response-form-el"
                                                data-id="<?= (int)$feedbackId ?>"
                                                class="response-form"
                                                onsubmit="return handleResponseSave(event)">
                                                <textarea name="officialResponse" rows="5" class="form-textarea"
                                                    placeholder="Write your official response..."><?= htmlspecialchars($responseContent) ?></textarea>
                                                <div class="response-form-action">
                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        <?= $responseContent !== "" ? 'Update Response' : 'Save Response' ?>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline" onclick="toggleResponseForm(false)">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    <?php else: ?>
                                        <?php if (!empty(trim($d['official_response']['content'] ?? ""))): ?>
                                            <p><?= nl2br(htmlspecialchars(trim($d['official_response']['content']))) ?></p>
                                        <?php else: ?>
                                            <p class="no-response">No official response has been added yet.</p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Sidebar -->
                    <div class="side-section <?= $this->isAdmin ? 'no-header' : 'with-header' ?>">
                        <!-- Voting -->
                        <div class="vote-card rounded-sm">
                            <div class="vote-section">
                                <?= $this->renderVoteSection($voteCount, (int)$feedbackId, $status, $isPublic, $userOptedPublic) ?>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="details-card rounded-sm">
                            <h3 class="details-title">Details</h3>
                            <div class="details-grid">
                                <div class="detail-item">
                                    <span class="detail-label">Status</span>

                                    <?php if ($this->isAdmin): ?>
                                        <div class="detail-value">
                                            <?= renderStatusSelector($status, 4) ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="detail-value sidebar-status <?= 'status-' . $status ?>">
                                            <?= htmlspecialchars(ucwords($status)) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Category</span>
                                    <span class="detail-value"><?= htmlspecialchars($category) ?></span>
                                </div>

                                <?php if ($this->isAdmin): ?>
                                    <?php if ($d['allow-public']): ?>
                                        <div class="detail-item">
                                            <span class="detail-label">Visibility</span>
                                            <div class="detail-value">
                                                <div class="visibility-control">
                                                    <label class="toggle-switch">
                                                        <input type="checkbox"
                                                            class="toggle-input visibility-toggle"
                                                            data-id="<?= $feedbackId ?>"
                                                            <?= $isPublic ? 'checked' : '' ?>>
                                                        <span class="toggle-slider"></span>
                                                    </label>
                                                    <span class="visibility-status">
                                                        <?= $isPublic ? 'Public' : 'Private' ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="detail-item">
                                            <span class="detail-label">Visibility</span>
                                            <span class="detail-value">
                                                <span class="status-badge user-optout rounded-sm">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 11H7v-2h5V7l4 4-4 4v-4z" />
                                                    </svg>
                                                    User kept private
                                                </span>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <div class="detail-item">
                                        <span class="detail-label">Contact</span>
                                        <span class="detail-value"><?= $contact ? htmlspecialchars($contact) : 'None' ?></span>
                                    </div>
                                <?php endif; ?>

                                <div class="detail-item">
                                    <span class="detail-label">Rating</span>
                                    <span class="detail-value"><?= $this->renderStars($rating) ?></span>
                                </div>
                            </div>

                            <div class="actions-section">
                                <button class="btn btn-primary copy-button" onclick="copyLink()">
                                    Share Feedback
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php
        return ob_get_clean();
    }


    private function renderStars(int $rating): string
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            $filled = $i <= $rating ? '⭐' : '☆';
            $html .= "<span class=\"star\">{$filled}</span>";
        }
        return $html;
    }

    private function renderFormatedParagraph(string $originalString): string
    {
        $safeString = htmlspecialchars($originalString);
        $stringWithBRs = nl2br($safeString);
        $stringWithPs = str_replace("<br />", "</p>\n<p>", $stringWithBRs);

        return "<p>" . $stringWithPs . "</p>";
    }

    private function renderVoteSection(int $voteCount, int $feedbackId, string $status, bool $isPublic, bool $userOptedPublic): string
    {
        // Case: not admin
        if (!$this->isAdmin) {
            if (strtolower($status) === 'resolved') {
                return <<<HTML
                <div class="vote-display">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4" />
                    </svg>
                    <span class="vote-count">$voteCount</span>
                </div>
                <span class="vote-label">votes</span>
            HTML;
            }

            return <<<HTML
            <button class="vote-button" onclick="handleVote({$feedbackId})">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M7 10l5-5 5 5" />
                    <path d="M12 5v14" />
                </svg>
                <span class="vote-count">$voteCount</span>
                <span class="vote-label">votes</span>
            </button>    
        HTML;
        }

        // Case: admin
        if (!$userOptedPublic) {
            return <<<HTML
            <span class="status-badge user-optout rounded-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" width='18' height='18'><rect width='18' height='18' fill="none"/><circle cx="128" cy="140" r="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="128" y1="160" x2="128" y2="184" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><rect x="40" y="88" width="176" height="128" rx="8" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/>
                    <path d="M88,88V56a40,40,0,0,1,80,0V88" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/>
                </svg>
                User kept private
            </span>
        HTML;
        }

        if ($userOptedPublic && !$isPublic) {
            return <<<HTML
            <span class="status-badge status-review rounded-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" width='18' height='18'><rect width='18' height='18' fill="none"/>
                    <circle cx="128" cy="136" r="88" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/>
                    <line x1="128" y1="136" x2="168" y2="96" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="104" y1="16" x2="152" y2="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/>
                </svg>
                Pending Approval
            </span>
            <div class="vote-display">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 12l2 2 4-4" />
                </svg>
                <span class="vote-count">$voteCount</span>
            </div>
            <span class="vote-label">votes</span>            
        HTML;
        }

        if ($isPublic) {
            return <<<HTML
            <span class="status-badge status-resolved rounded-sm">
                Approved to public
            </span>
            <div class="vote-display">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 12l2 2 4-4" />
                </svg>
                <span class="vote-count">$voteCount</span>
            </div>
            <span class="vote-label">votes</span> 
        HTML;
        }

        return '';
    }
}
