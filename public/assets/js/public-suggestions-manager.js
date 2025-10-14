document.addEventListener("DOMContentLoaded", () => {
  class PublicSuggestionsManager {
    constructor(initialData) {
      this.form = document.getElementById("public-feedback-filters-form");
      this.container = document.getElementById("suggestionsContainer");
      this.mainContainer = document.querySelector(".suggestions-main .container");
      this.errorContainer = document.createElement("div");
      this.container.parentElement.insertBefore(this.errorContainer, this.container);

      // Infinite Scroll Setup
      this.scrollTrigger = this.createScrollTrigger();
      this.observer = new IntersectionObserver(
        (entries) => {
          if (entries[0].isIntersecting) {
            this.loadMoreResults();
          }
        },
        { rootMargin: "200px" }
      );
      this.observer.observe(this.scrollTrigger);

      // State Management
      this.limit = 10;
      this.offset = initialData.feedbacks ? initialData.feedbacks.length : 0;
      this.totalAvailable = initialData.total || 0;
      this.isLoadingMore = false;
      this.searchTimeout = null;

      this.bindEvents();
      this.updateScrollTriggerVisibility();
    }

    createScrollTrigger() {
      const trigger = document.createElement("div");
      trigger.id = "infinite-scroll-trigger";
      trigger.innerHTML = `<span>Loading...</span>`;
      this.container.insertAdjacentElement("afterend", trigger);
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
      this.offset = 0;
      this.totalAvailable = 0;
      this.loadFilteredSuggestions(false);
    }

    loadMoreResults() {
      if (this.isLoadingMore || this.offset >= this.totalAvailable) return;
      this.loadFilteredSuggestions(true);
    }

    async loadFilteredSuggestions(isAppending = false) {
      const filters = this.getFilters(isAppending);
      const queryParams = new URLSearchParams(filters);

      if (!isAppending) {
        this.showLoading();
      } else {
        this.isLoadingMore = true;
        this.scrollTrigger.classList.add("loading");
      }
      this.hideError();

      try {
        const response = await fetch(`/api/public-suggestions?${queryParams}`);
        if (!response.ok) throw new Error("Network response was not ok.");

        const result = await response.json();
        if (result.success) {
          this.totalAvailable = result.data.total;
          this.offset += result.data.feedbacks.length;
          this.renderSuggestionCards(result.data.feedbacks, isAppending);
          this.updateScrollTriggerVisibility();
        } else {
          throw new Error(result.message || "Failed to load suggestions.");
        }
      } catch (error) {
        console.error("Error:", error);
        this.showError(error.message);
      } finally {
        if (!isAppending) {
          this.hideLoading();
        } else {
          this.isLoadingMore = false;
          this.scrollTrigger.classList.remove("loading");
        }
      }
    }

    renderSuggestionCards(suggestions, isAppending) {
      if (!isAppending && suggestions.length === 0) {
        this.showEmptyState();
        return;
      }
      const newHtml = suggestions.map((suggestion) => this.createCardHtml(suggestion)).join("");
      if (isAppending) {
        this.container.insertAdjacentHTML("beforeend", newHtml);
      } else {
        this.container.innerHTML = newHtml;
      }
    }

    // In public-suggestions-manager.js

    createCardHtml(data) {
      const status = data.status || "new";
      const date = new Date(data.created_at).toLocaleDateString("en-US", {
        month: "short",
        day: "numeric",
        year: "numeric",
      });

      const escape = (str) => {
        if (str === null || str === undefined) return "";
        const p = document.createElement("p");
        p.textContent = str;
        return p.innerHTML;
      };

      const voteButtonHtml = `<button class="vote-button" data-id="${escape(
        data.id
      )}" onclick="event.preventDefault(); event.stopPropagation(); handleVote(this, '${escape(
        data.id
      )}')"><svg width="20" height="20" viewBox="0 0 24 24"><path d="M7 10l5-5 5 5" /><path d="M12 5v14" /></svg><span class="vote-count">${escape(
        String(data.votes)
      )}</span></button>`;
      const resolvedVoteHtml = `<div class="vote-display"><svg width="20" height="20" viewBox="0 0 24 24"><path d="M7 10l5-5 5 5" /><path d="M12 5v14" /></svg><span class="vote-count">${escape(
        String(data.votes)
      )}</span></div>`;

      // ✅ This HTML structure now EXACTLY matches your PHP function
      return `
    <a href="/feedback/${escape(data.id)}" class="feedback-card-link">
        <div class="feedback-card rounded-sm" data-category="${escape(data.cat)}" data-status="${escape(
        status
      )}">
            <div class="card-left">
                <div class="category-indicator" style="--indicator-color: ${escape(
                  data.category_color || "#6c757d"
                )};"></div>
                <div class="card-content">
                    <div class="card-meta">
                        <span class="category-name">${escape(data.cat)}</span>
                        <span class="date-posted">${
                          status.toLowerCase() === "resolved" ? "Resolved " : ""
                        }${date}</span>
                    </div>
                    <h3 class="feedback-title">${escape(data.title)}</h3>
                    <p class="feedback-preview">${escape(data.message)}</p>
                </div>
            </div>
            <div class="card-right">
                <div class="rounded-sm status-badge status-${status.toLowerCase()}">${escape(status)}</div>
                <div class="vote-section">
                    ${status.toLowerCase() === "resolved" ? resolvedVoteHtml : voteButtonHtml}
                    <span class="vote-label">votes</span>
                </div>
            </div>
        </div>
    </a>`;
    }

    updateScrollTriggerVisibility() {
      this.scrollTrigger.style.display = this.offset < this.totalAvailable ? "block" : "none";
    }

    showLoading() {
      const loadingOverlay = document.createElement("div");
      loadingOverlay.className = "loading-overlay";
      loadingOverlay.innerHTML = `<span>Loading...</span>`;
      this.mainContainer.style.position = "relative";
      this.mainContainer.appendChild(loadingOverlay);
    }

    hideLoading() {
      const loadingOverlay = this.mainContainer.querySelector(".loading-overlay");
      if (loadingOverlay) loadingOverlay.remove();
    }

    showError(message) {
      this.container.style.display = "none";
      this.errorContainer.innerHTML = `<div class="error-state"><p>${message}</p></div>`;
      this.errorContainer.style.display = "block";
    }

    showEmptyState() {
      this.container.innerHTML = `
    <div class="empty-state">
      <h3 class="empty-state__title">No Suggestions Found</h3>
      <p class="empty-state__message">Try adjusting your search or filter criteria to find what you're looking for.</p>
    </div>`;
    }

    hideError() {
      this.container.style.display = "grid";
      this.errorContainer.style.display = "none";
      this.errorContainer.innerHTML = "";
    }
  }

  if (typeof initialSuggestions !== "undefined") {
    new PublicSuggestionsManager(initialSuggestions);
  }
});
