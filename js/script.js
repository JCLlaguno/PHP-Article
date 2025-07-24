"use strict";
const mobileToggle = document.querySelector(".mobile-toggle-btn");
const mobileMenu = document.querySelector(".mobile-menu");
const mobileMenuCloseBtn = document.querySelector(
  ".mobile-menu .mobile-toggle-btn"
);

mobileToggle?.addEventListener("click", () => {
  mobileMenu?.classList.toggle("show-menu");
});
mobileMenuCloseBtn?.addEventListener("click", () => {
  mobileMenu?.classList.toggle("show-menu");
});

hugerte?.init({
  selector: "#article-content",
  branding: false,
});

// DELETE modal WITHOUT page reload
const deleteButton = document.querySelectorAll(".action-delete-btn");
const deleteModal = document.querySelector(".delete-modal");
const deleteModalContent = document.querySelector(".delete-modal-content");
const deleteModalInput = document.querySelector(".id-input");
const deleteModalCancel = document.querySelector(".modal-cancel-btn");
const deleteModalConfirm = document.querySelector(".modal-confirm-btn");

// if NO is selected in modal
deleteModalCancel?.addEventListener("click", (e) => {
  e.preventDefault();
  // hide custom DELETE modal
  deleteModal?.classList.remove("show-modal");
  // enable scrolling
  document.body.style.overflow = "auto";
});

// // if action delete btn is CLICKED
deleteButton?.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault();
    // show custom DELETE modal
    deleteModal?.classList.toggle("show-modal");
    // disable scrolling
    document.body.style.overflow = "hidden";
    // pass row id to custom DELETE modal input
    deleteModalInput?.setAttribute("value", `${btn.dataset.id}`);
  });
});

// id YES is selected on modal
deleteModalContent?.addEventListener("submit", async (e) => {
  e.preventDefault(); // Prevent default form submission

  const form = e.target;
  const formData = new FormData(form); // Create FormData object from the form
  const id = deleteModalInput.value;

  const response = await fetch("deleteArticle.php", {
    method: "POST",
    body: formData, // Send the FormData object directly
  });

  if (!response.ok) return;

  // find row containing the delete button
  const rowIndex = [...deleteButton].findIndex((el) => +el.dataset.id === +id);
  const row = deleteButton[+rowIndex].closest("tr");

  // remove row
  row.remove();
  deleteModal?.classList.remove("show-modal");

  // enable scrolling
  document.body.style.overflow = "auto";
});
