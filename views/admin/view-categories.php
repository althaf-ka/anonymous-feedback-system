<?php
$title = "Categories | Admin Panel";
$headAssets[] = '<link rel="stylesheet" href="/assets/css/pages/view-categories.css">';
$showSidebar = $showHeader = true;

require_once __DIR__ . '/../admin/components/modal.php';

// Example dataset
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
                            <span class="category-name"><?= htmlspecialchars(ucwords($cat['name'])) ?></span>
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
                            <button class="delete-btn rounded-sm" onclick="openDeleteModal(<?= $cat['id'] ?>, '<?= htmlspecialchars(addslashes($cat['name'])) ?>')">
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
                    <!-- Calendar SVG -->
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
        <form id="add-category-form" method="post" class="category-form">
            <div class="category-form__group">
                <label for="category-name" class="form-label">Category Name</label>
                <input 
                    type="text" 
                    id="category-name" 
                    name="name" 
                    placeholder="Enter category name" 
                    required 
                    class="form-input"
                >
            </div>

            <div class="category-form__group">
                <label for="categoryColor" class="form-label">Category Color</label>
                <div class="category-form__color-wrapper">
                    <input type="color" id="categoryColor" name="color" class="category-form__color" value="#000000" >
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

    function capitalizeWords(str) {
        return str.replace(/\b\w/g, char => char.toUpperCase());
    }

    function createCategoryRow(id, name, color) {
        const row = document.createElement("div");
        row.className = "table-row";
        row.dataset.categoryId = id;

        row.innerHTML = `
            <div class="cell cell-name"><span class="category-name">${capitalizeWords(name)}</span></div>
            <div class="cell cell-color">
                <div class="color-display">
                    <span class="color-swatch" style="background-color: ${color}"></span>
                    <code class="color-code">${color}</code>
                </div>
            </div>
            <div class="cell cell-feedbacks">
                <div class="feedback-stats">
                    <span class="feedback-count">0</span>
                    <span class="feedback-label">items</span>
                </div>
            </div>
            <div class="cell cell-actions">
                <button class="delete-btn rounded-sm" onclick="openDeleteModal(${id}, '${name}')">Delete</button>
            </div>
        `;
        return row;
    }

    function openDeleteModal(id, name) {
        categoryToDelete = {
            id,
            name
        };

        document.getElementById("deleteModalMessage").innerHTML =
            `Are you sure you want to delete <strong>${capitalizeWords(name)}</strong>? This action cannot be undone.`;

        const confirmBtn = document.getElementById("confirmDeleteBtn");
        confirmBtn.onclick = () => {
            deleteCategory(id, name);
            closeModal("confirmDelete");
        };

        openModal("confirmDelete");
    }

    async function deleteCategory(id, name) {
        const row = document.querySelector(`[data-category-id="${id}"]`);
        const deleteBtn = row.querySelector(".delete-btn");

        deleteBtn.disabled = true;
        deleteBtn.innerHTML = `<span class="loading-spinner"></span> Deleting...`;

        try {
            const response = await fetch("/admin/categories/delete", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    id
                })
            });

            const result = await response.json();

            if (result.success) {
                row.style.opacity = "0";
                row.style.transform = "translateX(-20px)";
                setTimeout(() => row.remove(), 300);

                if (!document.querySelector(".table-row")) location.reload();
            } else {
                throw new Error(result.message || "Failed to delete category");
            }
        } catch (error) {
            alert("Error: " + error.message);
            deleteBtn.disabled = false;
            deleteBtn.textContent = "Delete";
        }
    }

    const form = document.getElementById("add-category-form");

    form.addEventListener("submit", async function(e) {
        e.preventDefault();

        const saveBtn = document.querySelector('button[type="submit"][form="add-category-form"]');
        saveBtn.disabled = true;
        saveBtn.textContent = "Saving...";

        const formData = new FormData(form);

        try {
            const response = await fetch("/admin/categories/add", {
                method: "POST",
                body: formData,
                headers: {
                    "Accept": "application/json"
                }
            });

            const result = await response.json();

            if (result.success) {
                closeModal("addCategoryModal");

                const tableBody = document.querySelector(".table-body");
                const name = formData.get("name");
                const color = formData.get("color");

                const newRow = createCategoryRow(result.data.id, name, color);
                tableBody.appendChild(newRow);

                form.reset();
                showToast("Category added successfully!", "success");
            } else {
                throw new Error(result.message || "Failed to add category");
            }
        } catch (err) {
            showToast(err.message, "error");
        } finally {
            saveBtn.textContent = "Save";
            saveBtn.disabled = false;
        }
    });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
