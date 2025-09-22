// File: /assets/js/components/voting.js

const VotedItems = {
  // Load voted items from local storage on initialization
  ids: JSON.parse(localStorage.getItem("voted_feedback_ids")) || {},

  hasVoted(id) {
    return this.ids[id] === true;
  },

  add(id) {
    this.ids[id] = true;
    this.save();
  },

  save() {
    localStorage.setItem("voted_feedback_ids", JSON.stringify(this.ids));
  },
};

async function handleVote(voteButton) {
  const feedbackId = voteButton.dataset.id;
  if (!feedbackId || voteButton.disabled) {
    return;
  }

  const svgIcon = voteButton.querySelector("svg");
  const spinner = document.createElement("span");
  spinner.className = "loading-spinner";

  voteButton.disabled = true;
  voteButton.classList.add("loading");
  if (svgIcon) {
    svgIcon.replaceWith(spinner);
  }

  try {
    const response = await fetch("/feedback/vote", {
      method: "POST",
      headers: { "Content-Type": "application/json", "X-Requested-With": "XMLHttpRequest" },
      body: JSON.stringify({ feedbackId: feedbackId }),
    });

    const result = await response.json();

    if (result.data && typeof result.data.voteCount !== "undefined") {
      const countElement = voteButton.querySelector(".vote-count");
      if (countElement) {
        countElement.textContent = result.data.voteCount;
      }
    }

    if (result.success) {
      showToast(result.message || "Vote counted!", "success");
    } else {
      showToast(result.message || "Could not cast vote.", "warning");
    }

    VotedItems.add(feedbackId);
    voteButton.classList.add("voted");
  } catch (error) {
    console.error("An error occurred during the vote process:", error);
    showToast("A network error occurred. Please try again.", "error");
    voteButton.disabled = false;
  } finally {
    voteButton.classList.remove("loading");
    if (svgIcon) {
      spinner.replaceWith(svgIcon);
    }
  }
}

function updateVoteButtonStates() {
  document.querySelectorAll(".vote-button").forEach((button) => {
    const feedbackId = button.dataset.id;
    if (feedbackId && VotedItems.hasVoted(feedbackId)) {
      button.disabled = true;
      button.classList.add("voted");
    }
  });
}

document.addEventListener("DOMContentLoaded", updateVoteButtonStates);
document.addEventListener("click", (event) => {
  const voteButton = event.target.closest(".vote-button");
  if (voteButton) {
    handleVote(voteButton);
  }
});

// For infinite scroll, update button states when new content is added
document.addEventListener("content-updated", updateVoteButtonStates);
