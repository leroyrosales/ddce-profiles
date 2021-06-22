const modal = document.getElementById("profileInfoModal");
let profileImage = document.querySelectorAll(".ddce-profile-container");

// empty fields function.
function resetModalData() {
  document.querySelector("#profileInfoModal .modal-profile-name").textContent =
    "";
  document.querySelector("#profileInfoModal .modal-profile-role").textContent =
    "";
}

profileImage.forEach((profile) => {
  profile.addEventListener("click", (e) => {
    e.preventDefault();

    // Modal name
    document.querySelector(
      "#profileInfoModal .modal-profile-name"
    ).textContent = profile.querySelector(
      ".ddce-profile-name"
    ).textContent;
    document.querySelector(
      "#profileInfoModal .modal-profile-role"
    ).textContent = profile.querySelector(
      ".ddce-profile-role"
    ).textContent;
    document.querySelector(
        "#profileInfoModal .modal-profile-background"
      ).innerHTML = profile.querySelector(
        ".ddce-profile-background"
      ).innerHTML;

    document.body.classList.add("modal-open");
    modal.classList.add("display-modal");
    modal.style.visibility = "visible";
    modal.style.opacity = "1";
  });
});

// Trigger the click event when you hit the escape key.
document.addEventListener("keyup", (e) => {
  if (e.key === "Escape") {
    // esc key
    document.querySelector(".modal-info .close").click();
  }
});

// Click to close modal.
document.querySelectorAll(".modal-info .close").forEach((closeButton) => {
  closeButton.addEventListener("click", (e) => {
    e.preventDefault();

    if (modal.classList.contains("display-modal")) {
      document.body.classList.remove("modal-open");
      modal.classList.remove("display-modal");
      modal.style.visibility = "hidden";
      modal.style.opacity = "0";
      resetModalData();
    }
  });
});
