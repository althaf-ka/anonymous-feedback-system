document.addEventListener("DOMContentLoaded", () => {
  const renderStatusSelectorHTML = (currentStatus, feedbackId) => {
    const statuses = {
      new: "New",
      review: "In Review",
      progress: "In Progress",
      resolved: "Resolved",
    };
    const currentLabel = statuses[currentStatus] || "Status";
    let optionsHTML = "";
    for (const [key, label] of Object.entries(statuses)) {
      optionsHTML += `<li data-value="${key}" class="status-dropdown__option status-${key}${
        key === currentStatus ? " active" : ""
      }">${label}</li>`;
    }
    return `
        <div class="status-dropdown" data-id="${feedbackId}">
            <button type="button" class="status-dropdown__btn rounded-sm status-${currentStatus}">
                <span class="status-dropdown__label">${currentLabel}</span>
                <svg class="status-dropdown__chevron" width="12" height="12" viewBox="0 0 24 24"><path fill="currentColor" d="M7 10l5 5 5-5z" /></svg>
            </button>
            <ul class="status-dropdown__menu rounded-sm">${optionsHTML}</ul>
        </div>`;
  };

  class FeedbackFilters {
    constructor(initialData) {
      this.form = document.getElementById("feedback-filters-form");
      this.feedbackTable = this.form.querySelector(".feedback-table");
      this.tableBody = this.feedbackTable.querySelector(".table-body");
      this.tableWrapper = this.form.querySelector(".table-wrapper");
      this.errorContainer = document.getElementById("feedback-error-container");
      this.deleteButton = this.form.querySelector(".bulk-delete-btn");

      // Infinite Scroll State
      this.limit = 20;
      this.offset = initialData.feedbacks ? initialData.feedbacks.length : 0;
      this.totalAvailable = initialData.total || 0;
      this.isLoadingMore = false;
      this.scrollTrigger = this.createScrollTrigger();

      // Intersection Observer Setup
      this.observer = new IntersectionObserver(
        (entries) => {
          if (entries[0].isIntersecting) {
            this.loadMoreResults();
          }
        },
        { rootMargin: "200px" } // Load 200px before it becomes visible
      );
      this.observer.observe(this.scrollTrigger);

      this.searchTimeout = null;
      this.bindEvents();
      this.toggleDeleteButton();
      this.updateScrollTriggerVisibility(this.offset);
    }

    createScrollTrigger() {
      const trigger = document.createElement("div");
      trigger.id = "infinite-scroll-trigger";
      trigger.innerHTML = `<span>Loading more...</span>`;
      this.tableWrapper.insertAdjacentElement("afterend", trigger);
      return trigger;
    }

    bindEvents() {
      const searchInput = this.form.querySelector('input[name="search"]');
      const selects = this.form.querySelectorAll("select");
      searchInput.addEventListener("input", () => {
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => this.handleFilterChange(), 350);
      });
      selects.forEach((select) => {
        select.addEventListener("change", () => this.handleFilterChange());
      });
      this.form.addEventListener("change", (event) => {
        if (event.target.matches(".row-cb")) {
          this.toggleDeleteButton();
        }
      });

      this.deleteButton.addEventListener("click", (e) => {
        e.preventDefault();
        this.handleDeleteSelected();
      });
    }

    toggleDeleteButton() {
      const checkBoxes = this.form.querySelectorAll(".row-cb");
      const isAnyChecked = [...checkBoxes].some((cb) => cb.checked);
      this.deleteButton.classList.toggle("show", isAnyChecked);
    }

    getFilters(forLoadMore = false) {
      const formData = new FormData(this.form);
      const filters = {};
      for (let [key, value] of formData.entries()) {
        if (value) filters[key] = value;
      }
      filters.limit = this.limit;
      filters.offset = forLoadMore ? this.offset : 0;
      return filters;
    }

    handleFilterChange() {
      this.hideError();
      this.feedbackTable.style.display = "";
      this.offset = 0;
      this.totalAvailable = 0;
      const filters = this.getFilters(false);
      this.loadFilteredFeedbacks(filters, false);
    }

    loadMoreResults() {
      if (this.isLoadingMore || this.offset >= this.totalAvailable) {
        return;
      }
      const filters = this.getFilters(true);
      this.loadFilteredFeedbacks(filters, true);
    }

    async loadFilteredFeedbacks(filters, isAppending = false) {
      if (!isAppending) {
        this.showLoading();
      } else {
        this.isLoadingMore = true;
        this.scrollTrigger.classList.add("loading");
      }
      this.hideError();

      try {
        const queryParams = new URLSearchParams(filters);
        const response = await fetch(`/admin/api/feedbacks?${queryParams}`);
        if (!response.ok) throw new Error(`Server responded with status ${response.status}`);
        const result = await response.json();
        if (result.success) {
          this.totalAvailable = result.data.total;
          this.offset += result.data.feedbacks.length;
          this.renderFeedbacks(result.data.feedbacks, isAppending);
          this.updateScrollTriggerVisibility(this.offset);
        } else {
          throw new Error(result.message || "Failed to load data.");
        }
      } catch (error) {
        console.error("Error loading feedbacks:", error);
        this.showError(`Failed to load filtered results: ${error.message}`);
      } finally {
        if (!isAppending) {
          this.hideLoading();
        } else {
          this.isLoadingMore = false;
          this.scrollTrigger.classList.remove("loading");
        }
      }
    }

    updateScrollTriggerVisibility(currentCount) {
      if (currentCount > 0 && currentCount < this.totalAvailable) {
        this.scrollTrigger.style.display = "block";
      } else {
        this.scrollTrigger.style.display = "none";
      }
    }

    renderFeedbacks(feedbacks, isAppending = false) {
      const newHtml = feedbacks
        .map((fb) => {
          const title = fb.title || fb.subject || "";
          const category = fb.cat || fb.category || "";
          const votes = fb.allow_public ? fb.votes || 0 : "–";
          const date = new Date(fb.created_at).toLocaleDateString("en-US", {
            month: "short",
            day: "numeric",
            year: "numeric",
          });
          return `
            <div role="row" class="table-row">
                <div role="gridcell" class="cell checkbox-cell"><input type="checkbox" class="row-cb" name="ids[]" value="${
                  fb.id
                }" onclick="event.stopPropagation()"></div>
                <a href="/admin/feedback/${fb.id}" class="row-link" data-id="${fb.id}">
                    <div role="gridcell" class="cell">${title}</div>
                    <div role="gridcell" class="cell">${category}</div>
                    <div role="gridcell" class="cell time-cell">${date}</div>
                    <div role="gridcell" class="cell votes-cell">${votes}</div>
                </a>
                <div role="gridcell" class="cell status-cell">${renderStatusSelectorHTML(
                  fb.status,
                  fb.id
                )}</div>
            </div>`;
        })
        .join("");

      if (isAppending) {
        this.tableBody.insertAdjacentHTML("beforeend", newHtml);
      } else {
        if (feedbacks.length === 0) {
          this.showEmptyState();
        } else {
          this.tableBody.innerHTML = newHtml;
        }
      }
      this.toggleDeleteButton();
    }

    _displayMessage(message, type = "info") {
      this.feedbackTable.style.display = "none";
      this.tableBody.innerHTML = "";
      this.errorContainer.innerHTML = `<div class="table-message-state ${type}"><p>${message}</p></div>`;
      this.errorContainer.style.display = "block";
    }
    showEmptyState() {
      this._displayMessage("No feedbacks found matching your criteria.", "empty");
    }
    showError(message) {
      this._displayMessage(message, "error");
    }
    hideError() {
      this.errorContainer.style.display = "none";
      this.errorContainer.innerHTML = "";
    }
    showLoading() {
      const loadingOverlay = document.createElement("div");
      loadingOverlay.className = "loading-overlay";
      loadingOverlay.innerHTML = `<span>Loading...</span>`;
      this.tableWrapper.style.position = "relative";
      this.tableWrapper.appendChild(loadingOverlay);
    }
    hideLoading() {
      const loadingOverlay = this.tableWrapper.querySelector(".loading-overlay");
      if (loadingOverlay) loadingOverlay.remove();
    }

    async handleDeleteSelected() {
      const ids = [...this.form.querySelectorAll(".row-cb:checked")].map((cb) => cb.value);

      if (ids.length === 0) {
        showToast("Please select at least one item to delete.", "warning");
        return;
      }

      const confirmed = await showConfirmationModal(
        "Confirm Deletion",
        `Are you sure you want to delete ${ids.length} item(s)? This action cannot be undone.`
      );

      if (!confirmed) {
        return;
      }

      this.deleteButton.disabled = true;
      this.deleteButton.innerHTML = `<span class="loading-spinner"></span> Deleting...`;

      try {
        const response = await fetch("/admin/delete/feedback", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest",
          },
          body: JSON.stringify({ ids }),
        });

        const result = await response.json();

        if (result.success) {
          showToast(result.message || "Items deleted successfully.", "success");

          this.handleFilterChange();
        } else {
          throw new Error(result.message || "Failed to delete the selected items.");
        }
      } catch (err) {
        showToast(err.message, "error");
      } finally {
        this.deleteButton.disabled = false;
        this.deleteButton.innerHTML = "Delete Selected";
        this.toggleDeleteButton();
      }
    }
  }

  if (typeof initialFeedbackData !== "undefined") {
    new FeedbackFilters(initialFeedbackData);
  }

  function showConfirmationModal(title, message) {
    return new Promise((resolve) => {
      const modal = document.getElementById("delete-confirmation-modal");
      if (!modal) {
        resolve(false);
        return;
      }

      modal.querySelector(".modal-header h2").textContent = title;
      modal.querySelector(".modal-body").innerHTML = `<p>${message}</p>`;

      const confirmBtn = modal.querySelector("#confirm-delete-btn");
      const cancelBtns = modal.querySelectorAll("[data-close-modal]");

      const onConfirm = () => {
        cleanup();
        resolve(true);
      };

      const onCancel = () => {
        cleanup();
        resolve(false);
      };

      const cleanup = () => {
        confirmBtn.removeEventListener("click", onConfirm);
        cancelBtns.forEach((btn) => btn.removeEventListener("click", onCancel));
        closeModal("delete-confirmation-modal");
      };

      confirmBtn.addEventListener("click", onConfirm, { once: true });
      cancelBtns.forEach((btn) => btn.addEventListener("click", onCancel, { once: true }));

      openModal("delete-confirmation-modal");
    });
  }
});
