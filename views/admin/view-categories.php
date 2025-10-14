<?php
$seo = [
    'title' => 'Manage Categories | Admin Panel',
    'description' => 'Add, edit, and delete feedback categories for the system.'
];
$headAssets[] = '<link rel="stylesheet" href="/assets/css/pages/view-categories.css">';
$showSidebar = $showHeader = true;

require_once __DIR__ . '/../admin/components/modal.php';


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
                <?php foreach ($categories['categories'] as $cat): ?>
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
    class CategoryManager {
        constructor(initialData) {
            this.tableBody = document.querySelector(".table-body");
            this.addCategoryForm = document.getElementById("add-category-form");
            this.confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
            this.categoryToDelete = null;

            // --- Infinite Scroll State ---
            this.limit = <?= $categories['limit'] ?? 8 ?>; // Use the limit from the initial load
            this.offset = initialData.categories ? initialData.categories.length : 0;
            this.totalAvailable = initialData.total || 0;
            this.isLoadingMore = false;

            this.setupScrollObserver();
            this.bindEvents();
            this.updateScrollTriggerVisibility();
        }

        setupScrollObserver() {
            this.scrollTrigger = document.createElement("div");
            this.scrollTrigger.id = "infinite-scroll-trigger";
            this.scrollTrigger.innerHTML = `<span>Loading more...</span>`;
            document.querySelector('.table-wrapper').insertAdjacentElement("afterend", this.scrollTrigger);

            this.observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    this.loadMoreCategories();
                }
            }, {
                rootMargin: "200px"
            });

            this.observer.observe(this.scrollTrigger);
        }

        bindEvents() {
            this.addCategoryForm.addEventListener("submit", (e) => this.handleAddCategory(e));

            // Use event delegation for delete buttons
            this.tableBody.addEventListener('click', (e) => {
                const deleteBtn = e.target.closest('.delete-btn');
                if (deleteBtn) {
                    const row = deleteBtn.closest('.table-row');
                    const id = row.dataset.categoryId;
                    const name = row.querySelector('.category-name').textContent;
                    this.openDeleteModal(id, name);
                }
            });

            this.confirmDeleteBtn.addEventListener('click', () => {
                if (this.categoryToDelete) {
                    this.deleteCategory(this.categoryToDelete.id, this.categoryToDelete.name);
                    closeModal("confirmDelete");
                }
            });
        }

        capitalizeWords(str) {
            return str.replace(/\b\w/g, char => char.toUpperCase());
        }

        createCategoryRow(id, name, color, feedbackCount = 0) {
            const row = document.createElement("div");
            row.className = "table-row";
            row.dataset.categoryId = id;

            const safeName = name.replace(/'/g, "&apos;").replace(/"/g, "&quot;");

            row.innerHTML = `
            <div class="cell cell-name"><span class="category-name">${this.capitalizeWords(name)}</span></div>
            <div class="cell cell-color">
                <div class="color-display">
                    <span class="color-swatch" style="background-color: ${color}"></span>
                    <code class="color-code">${color}</code>
                </div>
            </div>
            <div class="cell cell-feedbacks">
                <div class="feedback-stats">
                    <span class="feedback-count">${feedbackCount}</span>
                    <span class="feedback-label">items</span>
                </div>
            </div>
            <div class="cell cell-actions">
                <button class="delete-btn rounded-sm">Delete</button>
            </div>
        `;
            return row;
        }

        openDeleteModal(id, name) {
            this.categoryToDelete = {
                id,
                name
            };
            document.getElementById("deleteModalMessage").innerHTML =
                `Are you sure you want to delete <strong>${this.capitalizeWords(name)}</strong>? This action cannot be undone.`;
            openModal("confirmDelete");
        }

        async deleteCategory(id) {
            const row = document.querySelector(`[data-category-id="${id}"]`);
            const originalBtnText = this.confirmDeleteBtn.textContent;

            // Set loading state ON THE MODAL BUTTON
            this.confirmDeleteBtn.disabled = true;
            this.confirmDeleteBtn.innerHTML = `<span class="loading-spinner"></span> Deleting...`;

            try {
                const response = await fetch("/admin/delete/category", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({
                        id
                    })
                });
                const result = await response.json();

                if (result.success) {
                    closeModal("confirmDelete");
                    row.style.opacity = "0";
                    setTimeout(() => row.remove(), 300);
                    showToast("Category deleted successfully!", "success");
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                showToast(error.message || "Failed to delete category", "error");
            } finally {
                this.confirmDeleteBtn.disabled = false;
                this.confirmDeleteBtn.innerHTML = originalBtnText;
                this.categoryToDelete = null; // Clear the state
            }
        }

        async handleAddCategory(e) {
            e.preventDefault();
            const saveBtn = document.querySelector('button[type="submit"][form="add-category-form"]');
            saveBtn.disabled = true;
            saveBtn.textContent = "Saving...";

            const formData = new FormData(this.addCategoryForm);
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
                    const newRow = this.createCategoryRow(result.data.id, formData.get("name"), formData.get("color"));
                    this.tableBody.prepend(newRow);
                    this.addCategoryForm.reset();
                    showToast("Category added successfully!", "success");
                } else {
                    throw new Error(result.message);
                }
            } catch (err) {
                showToast(err.message || "Failed to add category", "error");
            } finally {
                saveBtn.textContent = "Save";
                saveBtn.disabled = false;
            }
        }

        // --- Infinite Scroll Methods ---

        updateScrollTriggerVisibility() {
            if (this.offset < this.totalAvailable) {
                this.scrollTrigger.style.display = 'block';
            } else {
                this.scrollTrigger.style.display = 'none';
            }
        }

        async loadMoreCategories() {
            if (this.isLoadingMore || this.offset >= this.totalAvailable) {
                return;
            }
            this.isLoadingMore = true;
            this.scrollTrigger.classList.add('loading');

            try {
                const response = await fetch(`/admin/api/categories?limit=${this.limit}&offset=${this.offset}`);
                const result = await response.json();

                if (result.success) {
                    const newCategories = result.data.categories;
                    this.offset += newCategories.length;

                    newCategories.forEach(cat => {
                        const newRow = this.createCategoryRow(cat.id, cat.name, cat.color, cat.feedbacks);
                        this.tableBody.appendChild(newRow);
                    });
                }
            } catch (err) {
                console.error("Failed to load more categories:", err);
            } finally {
                this.isLoadingMore = false;
                this.scrollTrigger.classList.remove('loading');
                this.updateScrollTriggerVisibility();
            }
        }
    }

    const initialData = <?= json_encode($categories) ?>;
    new CategoryManager(initialData);
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
