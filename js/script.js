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

// DELETE modal with page reload
// const deleteButton = document.querySelectorAll(".action-delete-btn");
// const deleteModal = document.querySelector(".delete-modal");
// const deleteModalInput = document.querySelector(".id-input");
// const deleteModalCancel = document.querySelector(".modal-cancel-btn");

// // if NO is selected in modal
// deleteModalCancel.addEventListener("click", (e) => {
//   e.preventDefault();
//   deleteModal.classList.remove("show-modal");
// });

// // if action delete btn is CLICKED
// deleteButton.forEach((btn) => {
//   btn.addEventListener("click", function (e) {
//     e.preventDefault();
//     // show custom DELETE modal
//     deleteModal.classList.toggle("show-modal");

//     // pass row id to custom DELETE modal
//     deleteModalInput.setAttribute("value", `${btn.dataset.id}`);
//   });
// });

// DELETE modal WITHOUT page reload
const deleteButton = document.querySelectorAll(".action-delete-btn");
const deleteButtonArr = [...deleteButton];
const deleteModal = document.querySelector(".delete-modal");
const deleteModalContent = document.querySelector(".delete-modal-content");
const deleteModalInput = document.querySelector(".id-input");
const deleteModalCancel = document.querySelector(".modal-cancel-btn");
const deleteModalConfirm = document.querySelector(".modal-confirm-btn");

// if NO is selected in modal
deleteModalCancel?.addEventListener("click", (e) => {
  e.preventDefault();
  deleteModal?.classList.remove("show-modal");
});

// // if action delete btn is CLICKED
deleteButton?.forEach((btn) => {
  btn.addEventListener("click", function (e) {
    e.preventDefault();
    // show custom DELETE modal
    deleteModal?.classList.toggle("show-modal");
    // pass row id to custom DELETE modal input
    deleteModalInput?.setAttribute("value", `${btn.dataset.id}`);
  });
});

deleteModalContent?.addEventListener("submit", async function (e) {
  e.preventDefault(); // Prevent default form submission

  const form = e.target;
  const formData = new FormData(form); // Create FormData object from the form
  const id = deleteModalInput.value;

  const response = await fetch("deleteArticle.php", {
    method: "POST",
    body: formData, // Send the FormData object directly
  });

  if (!response.ok) return;

  const rowIndex = deleteButtonArr.findIndex((el) => +el.dataset.id === +id);
  const row = deleteButton[+rowIndex].closest("tr");
  row.remove();
  deleteModal?.classList.remove("show-modal");
});
