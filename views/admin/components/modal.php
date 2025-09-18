<?php
function renderModal(string $id, string $title, string $body, string $footer = ''): void
{
?>
    <div id="<?= htmlspecialchars($id) ?>" class="modal-overlay hidden">
        <div class="modal rounded-sm">
            <header class="modal-header">
                <h2><?= htmlspecialchars($title) ?></h2>
                <button class="modal-close" data-close-modal="<?= htmlspecialchars($id) ?>">×</button>
            </header>

            <div class="modal-body">
                <?= $body ?>
            </div>

            <?php if (!empty($footer)): ?>
                <footer class="modal-footer">
                    <?= $footer ?>
                </footer>
            <?php endif; ?>
        </div>
    </div>
<?php
}
