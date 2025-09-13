// status-selector.php

document.addEventListener("click", (e) => {
  const dropdown = e.target.closest(".status-dropdown");
  const option = e.target.closest(".status-dropdown__option");

  if (dropdown && e.target.closest(".status-dropdown__btn")) {
    if (dropdown.classList.contains("open")) {
      dropdown.classList.remove("open"); 
    } else {
      document.querySelectorAll(".status-dropdown.open").forEach((el) =>
        el.classList.remove("open")
      );
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
    btn.querySelector(".status-dropdown__label").textContent = option.textContent;
    btn.className = `status-dropdown__btn status-${value}`; // apply global .status-* class

    dropdown.querySelectorAll(".status-dropdown__option")
    .forEach(opt => opt.classList.remove("active"));
    option.classList.add("active");

    dropdown.classList.remove("open");

    fetch(`/admin/feedback/update-status.php`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id, status: value }),
    });
  }

  // Close if clicking outside
  if (!dropdown) {
    document.querySelectorAll(".status-dropdown.open").forEach((el) =>
      el.classList.remove("open")
    );
  }
});


