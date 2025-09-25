// status-selector.php

document.addEventListener("click", async (e) => {
  const dropdown = e.target.closest(".status-dropdown");
  const option = e.target.closest(".status-dropdown__option");

  // Toggle dropdown open/close
  if (dropdown && e.target.closest(".status-dropdown__btn")) {
    if (dropdown.classList.contains("open")) {
      dropdown.classList.remove("open");
    } else {
      document.querySelectorAll(".status-dropdown.open").forEach((el) => el.classList.remove("open"));
      dropdown.classList.add("open");

      const menu = dropdown.querySelector(".status-dropdown__menu");
      menu.style.top = "";
      menu.style.bottom = "";
      const rect = menu.getBoundingClientRect();
      if (rect.bottom > window.innerHeight) {
        menu.style.top = "auto";
        menu.style.bottom = "100%";
      } else {
        menu.style.top = "100%";
        menu.style.bottom = "auto";
      }
    }
  }

  if (option && dropdown) {
    const value = option.dataset.value;
    const id = dropdown.dataset.id;

    const btn = dropdown.querySelector(".status-dropdown__btn");
    const label = btn.querySelector(".status-dropdown__label");

    // Store old value and label
    const oldValueClass = Array.from(btn.classList).find((cls) => cls.startsWith("status-"));
    const oldValue = oldValueClass.replace("status-", "");
    const oldLabel = label.textContent;
    const oldActiveOption = dropdown.querySelector(".status-dropdown__option.active");

    label.textContent = option.textContent;
    btn.className = `status-dropdown__btn status-${value}`;
    dropdown.querySelectorAll(".status-dropdown__option").forEach((opt) => opt.classList.remove("active"));
    option.classList.add("active");
    dropdown.classList.remove("open");

    const headerStatus = document.querySelector(".feedback-header .meta-item.status-element");
    if (headerStatus) {
      headerStatus.textContent = option.textContent;
      headerStatus.className = `rounded-sm status-${value} meta-item status-element`;
    }

    function revertUI() {
      label.textContent = oldLabel;
      btn.className = `status-dropdown__btn status-${oldValue}`;
      option.classList.remove("active");
      dropdown.querySelector(`[data-value="${oldValue}"]`)?.classList.add("active");

      if (headerStatus) {
        headerStatus.textContent = oldLabel;
        headerStatus.className = `rounded-sm status-${oldValue} meta-item status-element`;
      }
    }

    try {
      const res = await fetch("/admin/status/change", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id, status: value }),
      });

      const data = await res.json();

      if (data.success) {
        showToast(data.message || "Status updated successfully", "success");
      } else {
        revertUI();
        showToast(data.message || "Failed to update status", "error");
      }
    } catch (err) {
      revertUI();
      showToast("Something went wrong while updating status", "error");
    }
  }

  // Close dropdowns if clicking outside
  if (!dropdown) {
    document.querySelectorAll(".status-dropdown.open").forEach((el) => el.classList.remove("open"));
  }
});

//     FeedbackComponent.php

document.querySelectorAll(".visibility-toggle").forEach((toggle) => {
  toggle.addEventListener("change", async function () {
    const statusSpan = this.closest(".visibility-control").querySelector(".visibility-status");
    const isPublic = this.checked;

    statusSpan.textContent = isPublic ? "Public" : "Private";
    statusSpan.style.opacity = "0.5";

    try {
      const res = await fetch("/admin/feedback/set-visibility", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: this.dataset.id, isPublic }),
      });
      const json = await res.json();

      if (json.success) showToast(json.message, "success");
      else showToast(json.message, "error");

      statusSpan.style.opacity = "1";
    } catch (err) {
      this.checked = !isPublic;
      statusSpan.textContent = !isPublic ? "Public" : "Private";
      statusSpan.style.opacity = "1";
      showToast("Failed to update visibility", "error");
    }
  });
});

// Toggling the Official Response Element
function toggleResponseForm(showForm) {
  const view = document.getElementById("official-response-view");
  const form = document.getElementById("official-response-form");
  if (showForm) {
    view.style.display = "none";
    form.style.display = "block";
  } else {
    view.style.display = "block";
    form.style.display = "none";
  }
}

function handleResponseSave(e) {
  e.preventDefault();

  const form = e.target;
  const content = form.querySelector("textarea").value.trim();
  const feedbackId = form.dataset.id;

  fetch("/admin/feedback/set-official-response", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id: feedbackId, content }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (!data.success) throw new Error(data.message || "Failed to save response");

      updateResponseUI(content, new Date());
      showToast(data.message || "Official response saved", "success");
    })
    .catch((err) => {
      showToast(err.message, "error");
      console.error(err);
    });
}

function updateResponseUI(content, date) {
  const view = document.getElementById("official-response-view");
  const form = document.getElementById("official-response-form");

  const d = date ? new Date(date) : null;
  const formattedDate =
    d && !isNaN(d)
      ? d.toLocaleString("en-US", {
          year: "numeric",
          month: "short",
          day: "numeric",
          hour: "numeric",
          minute: "2-digit",
          hour12: true,
        })
      : "";

  view.innerHTML = content
    ? `<p>${escapeHtml(content).replace(/\n/g, "<br>")}</p>
       <button class="btn btn-sm btn-warning" onclick="toggleResponseForm(true)">Edit Response</button>`
    : `<p class="no-response">No official response has been added yet.</p>
       <button class="btn btn-sm btn-primary" onclick="toggleResponseForm(true)">Add Response</button>`;

  view.style.display = "block";
  form.style.display = "none";

  // 🔹 Update the header date
  const headerDate = document.querySelector(".card-header .response-date");
  if (headerDate) {
    headerDate.textContent = formattedDate;
  } else if (formattedDate) {
    const header = document.querySelector(".card-header");
    if (header) {
      const span = document.createElement("span");
      span.className = "response-date";
      span.textContent = formattedDate;
      header.appendChild(span);
    }
  }
}

function escapeHtml(str = "") {
  return str.replace(
    /[&<>"']/g,
    (tag) => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[tag])
  );
}

/// Model Contols // model.php
function openModal(id) {
  document.getElementById(id).classList.remove("hidden");
}

function closeModal(id) {
  document.getElementById(id).classList.add("hidden");
}

// Attach close buttons
document.addEventListener("click", function (e) {
  if (e.target.matches("[data-close-modal]")) {
    closeModal(e.target.getAttribute("data-close-modal"));
  }
  if (e.target.classList.contains("modal-overlay")) {
    closeModal(e.target.id);
  }
});
