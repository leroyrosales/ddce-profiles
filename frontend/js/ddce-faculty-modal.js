const modal = document.getElementById("facultyInfoModal");
let profileImage = document.querySelectorAll(".ddce-faculty-profile-image");

profileImage.forEach((profile) => {
  profile.addEventListener("click", (e) => {
    e.preventDefault();
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
      //   resetFields();
    }
  });
});
