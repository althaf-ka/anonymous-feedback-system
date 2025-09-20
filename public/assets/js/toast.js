if (!document.querySelector(".toast-container")) {
  const container = document.createElement("div");
  container.className = "toast-container";
  Object.assign(container.style, {
    position: "fixed",
    top: "1rem",
    right: "1rem",
    display: "flex",
    flexDirection: "column",
    gap: "0.5rem",
    zIndex: "9999",
    maxWidth: "90vw",
  });
  document.body.appendChild(container);
}

function showToast(message, type = "info", duration = 3000) {
  const toast = document.createElement("div");
  toast.className = `toast toast-${type}`;
  toast.innerHTML = `<div class="toast-content">${message}</div>`;

  Object.assign(toast.style, {
    padding: "1rem 1.5rem",
    borderRadius: "0.25rem",
    color: "white",
    fontWeight: "600",
    boxShadow: "0 8px 25px rgba(0,0,0,0.15)",
    opacity: "0",
    transform: "translateX(100%)",
    transition: "all 0.4s ease",
    background:
      type === "success"
        ? "var(--color-success, #22C55E)"
        : type === "warning"
        ? "var(--color-warning, #FBBF24)"
        : type === "info"
        ? "var(--color-info, #3B82F6)"
        : "var(--color-error, #EF4444)",
    maxWidth: "100%",
    wordWrap: "break-word",
  });

  const container = document.querySelector(".toast-container");
  container.appendChild(toast);

  requestAnimationFrame(() => {
    toast.style.opacity = "1";
    toast.style.transform = "translateX(0)";
  });

  setTimeout(() => {
    toast.style.opacity = "0";
    toast.style.transform = "translateX(100%)";
    toast.addEventListener("transitionend", () => toast.remove());
  }, duration);
}

// Make globally accessible
window.showToast = showToast;
