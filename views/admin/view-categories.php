<?php
$title = "Categories | Admin Panel";
$headAssets[] = '<link rel="stylesheet" href="/assets/css/pages/view-categories.css">';
$showSidebar = $showHeader = true;

require_once __DIR__ . '/../admin/components/modal.php';

$categories = [
    ['id' => 1, 'name' => 'Academics', 'color' => '#2563eb', 'feedbacks' => 42],
    ['id' => 2, 'name' => 'Facilities', 'color' => '#16a34a', 'feedbacks' => 28],
    ['id' => 3, 'name' => 'Food Services', 'color' => '#f59e0b', 'feedbacks' => 15],
    ['id' => 4, 'name' => 'Mental Health', 'color' => '#dc2626', 'feedbacks' => 9],
    ['id' => 5, 'name' => 'General', 'color' => '#6b7280', 'feedbacks' => 63],
];

ob_start();
?>

<section class="categories-section">
    <header class="page-head">
        <h1 class="admin-page-title">Categories</h1>
        <button type="button" class="btn btn-primary add-category-btn rounded-sm" onclick="openModal('addCategoryModal')">
            Add Category
        </button>
    </header>

    <div class="table-wrapper">
        <div class="categories-table rounded-sm">
            <div class="table-header">
                <div class="cell cell-name">Category</div>
                <div class="cell cell-color">Color</div>
                <div class="cell cell-feedbacks">Feedbacks</div>
                <div class="cell cell-actions">Actions</div>
            </div>

            <div class="table-body">
                <?php foreach ($categories as $cat): ?>
                    <div class="table-row" data-category-id="<?= $cat['id'] ?>">
                        <div class="cell cell-name">
                            <span class="category-name"><?= htmlspecialchars($cat['name']) ?></span>
                        </div>

                        <div class="cell cell-color">
                            <div class="color-display">
                                <span class="color-swatch" style="background-color: <?= $cat['color'] ?>"></span>
                                <code class="color-code"><?= htmlspecialchars($cat['color']) ?></code>
                            </div>
                        </div>

                        <div class="cell cell-feedbacks">
                            <div class="feedback-stats">
                                <span class="feedback-count"><?= number_format($cat['feedbacks']) ?></span>
                                <span class="feedback-label">items</span>
                            </div>
                        </div>

                        <div class="cell cell-actions">
                            <button
                                class="delete-btn rounded-sm"
                                onclick="openDeleteModal(<?= $cat['id'] ?>, '<?= htmlspecialchars($cat['name']) ?>')">
                                Delete
                            </button>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if (empty($categories)): ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <h3>No categories found</h3>
                <p>Create your first category to organize feedback submissions.</p>
                <a href="/admin/categories/add" class="btn btn-primary">Add Category</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
renderModal(
    id: "addCategoryModal",
    title: "Add New Category",
    body: '
        <form id="add-category-form" method="post" action="/admin/categories/add" class="category-form">
            <div class="category-form__group">
                <label for="categoryName" class="form-label">Category Name</label>
                <input 
                    type="text" 
                    id="category-name" 
                    name="Categoryname" 
                    placeholder="Enter category name" 
                    required 
                    class="form-input"
                >
            </div>

            <div class="category-form__group">
                <label for="categoryColor" class="form-label">Category Color</label>
                <div class="category-form__color-wrapper">
                    <input 
                        type="color" 
                        id="categoryColor" 
                        name="color" 
                        class="category-form__color"
                    >
                </div>
            </div>
        </form>
    ',
    footer: '
        <button class="btn btn-ghost" data-close-modal="addCategoryModal">Cancel</button>
        <button type="submit" form="add-category-form" class="btn btn-primary">Save</button>
    '
);

renderModal(
    id: "confirmDelete",
    title: "Confirm Delete",
    body: '<p id="deleteModalMessage">Are you sure you want to delete this category?</p>',
    footer: '
        <button class="btn btn-ghost" data-close-modal="confirmDelete">Cancel</button>
        <button id="confirmDeleteBtn" class="btn btn-danger">Delete</button>
    '
);

?>


<script>
    let categoryToDelete = null;

    function openDeleteModal(id, name) {

        categoryToDelete = {
            id,
            name
        };

        document.getElementById("deleteModalMessage").innerHTML =
            `Are you sure you want to delete <strong>${name}</strong> ? This action cannot be undone.`;

        const confirmBtn = document.getElementById("confirmDeleteBtn");
        confirmBtn.onclick = () => {
            deleteCategory(categoryToDelete.id, categoryToDelete.name);
            closeModal('confirmDelete');
        };

        openModal('confirmDelete');
    }

    async function deleteCategory(id, name) {
        const row = document.querySelector(`[data-category-id="${id}"]`);
        const deleteBtn = row.querySelector('.delete-btn');

        // Show loading state
        deleteBtn.disabled = true;
        deleteBtn.innerHTML = `
        <span class="loading-spinner"></span>
        Deleting...
    `;

        try {
            const response = await fetch('/admin/categories/delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id
                })
            });

            const result = await response.json();

            if (result.success) {
                // Animate removal
                row.style.opacity = '0';
                row.style.transform = 'translateX(-20px)';
                setTimeout(() => row.remove(), 300);

                if (document.querySelectorAll('.table-row').length === 0) {
                    location.reload();
                }
            } else {
                throw new Error(result.message || 'Failed to delete category');
            }
        } catch (error) {
            alert('Error: ' + error.message);

            // Reset button
            deleteBtn.disabled = false;
            deleteBtn.textContent = "Delete";
        }
    }
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>