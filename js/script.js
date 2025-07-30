"use strict";

// SHOW/HIDE mobile menu
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

  // show an ALERT message
  const html = `
    <div class="alert">
        <div class="alert-content">
            <p class="alert-title">Article was deleted</p>
        </div>
    </div>`;
  const articles = document.querySelector(".articles");
  articles.insertAdjacentHTML("afterbegin", html);

  const alert = document.querySelector(".alert");

  // close ALERT immediately if modal is clicked
  alert.addEventListener("click", () => alert.remove());

  // close ALERT after 2 sec
  setTimeout(() => {
    alert.remove();
  }, 2000);
});

// HIDE/SHOW create article form
const newBtn = document.querySelector(".new-btn-container .btn");
const createArticleModal = document.querySelector(".create-article-section");
const createArticleForm = document.querySelector(".create-article-form");

// show create article modal
newBtn.addEventListener("click", () =>
  createArticleModal.classList.add("show")
);

// close window when back is pressed
const backButton = document.querySelector(".form-btn-container .form-back-btn");
backButton.addEventListener("click", (e) => {
  e.preventDefault();
  createArticleModal.classList.remove("show");
});

// when form is submitted
createArticleForm.addEventListener("submit", async function (e) {
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);

  // Convert FormData to a plain JS object
  const data = {};
  formData.forEach((value, key) => {
    data[key] = value;
  });

  try {
    const response = await fetch("./createArticle.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json", // Sending JSON
      },
      body: JSON.stringify(data),
    });

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.error);
    }
    const successData = await response.json();
    console.log(successData.message);

    // close create article modal
    // createArticleModal.classList.remove("show");

    // reload the window
    window.location.reload();
  } catch (error) {
    alert(error);
  }
});
