"use strict";

// custom ALERT message
const bogoAlert = (message, alertType = "bg-black") => {
  const html = `
    <div class="alert">
        <div class="alert-content ${alertType}">
            <p class="alert-title">${message}</p>
        </div>
    </div>`;
  const articles = document.querySelector(".articles");
  articles.insertAdjacentHTML("afterbegin", html);

  const alert = document.querySelector(".alert");

  // close ALERT immediately if modal is clicked
  alert.addEventListener("click", () => {
    alert.remove();
    window.location.reload();
  });

  // close ALERT after 2 sec
  setTimeout(() => {
    alert.remove();
    window.location.reload();
  }, 2000);
};

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

// CREATE ARTICLE
// HIDE/SHOW create article form
const newBtn = document.querySelector(".new-btn-container .btn");
const createArticleModal = document.querySelector(".form-modal-container");
const createArticleForm = document.querySelector(".create-article-form");

// show create article modal
newBtn.addEventListener("click", () => {
  createArticleModal.classList.add("show");
  document.body.style.overflow = "hidden";
});

// close create article modal when back is pressed
const backButton = document.querySelector(".form-btn-container .form-back-btn");
backButton.addEventListener("click", (e) => {
  e.preventDefault();
  createArticleModal.classList.remove("show");
  document.body.style.overflow = "auto";
});

// when form is submitted
createArticleForm.addEventListener("submit", async function (e) {
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);

  // Convert FormData to a plain JS object
  const data = Object.fromEntries(formData);

  try {
    const response = await fetch("./createArticle.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json", // Sending JSON
      },
      body: JSON.stringify(data), // send data as JSON
    });

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.error);
    }
    const successData = await response.json();

    // close create article modal
    createArticleModal.classList.remove("show");

    // show an ALERT message
    bogoAlert(successData.message, "bg-blue");
  } catch (error) {
    alert(error);
  }
});

// UPDATE article
// HIDE/SHOW update article form
const updateArticleModal = document.querySelector(".update-article-section");
const updateArticleForm = document.querySelector(".update-article-form");
const actionUpdateButton = document.querySelectorAll(".action-update-btn");
const updateModalInput = updateArticleModal.querySelector(".id-input");

// LOAD article
const loadArticle = async (id) => {
  try {
    const response = await fetch(`./updateArticle.php?id=${id}`);

    if (!response.ok) throw new Error(`HTTP error ${response.status}`);

    const data = await response.json();

    // Fill form
    updateArticleForm.querySelector(".article-title").value =
      data.article_title || "";
    updateArticleForm.querySelector(".article-content").value =
      data.article_content || "";
  } catch (error) {
    console.error("Error loading article:", error);
  }
};

// // if action UPDATE btn is CLICKED
actionUpdateButton.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault();
    updateArticleModal.classList.add("show");
    document.body.style.overflow = "hidden";
    updateArticleModal.style.overflow = "scroll";

    // pass row id from table to custom UPDATE modal input
    updateModalInput?.setAttribute("value", `${btn.dataset.id}`);

    // initially load the selected article
    loadArticle(btn.dataset.id);
  });
});

// close update article modal when back is pressed
const updateBackButton = document.querySelector(
  ".update-article-section .form-back-btn"
);
updateBackButton.addEventListener("click", () => {
  updateArticleModal.classList.remove("show");
  document.body.style.overflow = "auto";
});

// if form is SUBMITTED
updateArticleModal.addEventListener("submit", async (e) => {
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);

  // Convert FormData to a plain JS object
  const data = Object.fromEntries(formData);

  try {
    const response = await fetch("./updateArticle.php", {
      method: "PUT",
      headers: {
        "Content-Type": "application/json", // Sending JSON
      },
      body: JSON.stringify(data), // send data as JSON
    });

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.error);
    }

    const successData = await response.json();

    // close create article modal
    updateArticleModal.classList.remove("show");

    // show an ALERT message
    bogoAlert(successData.message, "bg-green");
  } catch (error) {
    alert(error);
  }
});

// DELETE article
const deleteButton = document.querySelectorAll(".action-delete-btn");
const deleteModal = document.querySelector(".delete-modal");
const deleteModalContent = document.querySelector(".delete-modal-content");
const deleteModalInput = document.querySelector(".id-input");
const deleteModalCancel = document.querySelector(".modal-cancel-btn");
const deleteModalConfirm = document.querySelector(".modal-confirm-btn");

// if action delete btn is CLICKED
deleteButton?.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault();
    // show custom DELETE modal
    deleteModal?.classList.toggle("show-modal");
    // disable scrolling
    document.body.style.overflow = "hidden";
    // pass row id from table to custom DELETE modal input
    deleteModalInput?.setAttribute("value", `${btn.dataset.id}`);
  });
});

// if NO is selected in modal
deleteModalCancel?.addEventListener("click", (e) => {
  e.preventDefault();
  // hide custom DELETE modal
  deleteModal?.classList.remove("show-modal");
  // enable scrolling
  document.body.style.overflow = "auto";
});

// id YES is selected on modal
deleteModalContent?.addEventListener("submit", async (e) => {
  e.preventDefault(); // Prevent default form submission

  const deleteModalId = deleteModalInput.value; // get id from delete Modal
  const deleteIdObj = { "delete-id": deleteModalId }; // create a JS object containing the ID

  try {
    const response = await fetch("deleteArticle.php", {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json", // Sending JSON
      },
      body: JSON.stringify(deleteIdObj), // send data as JSON
    });

    if (!response.ok) throw new Error(await response.json().error);

    // find row containing the delete button
    const rowIndex = [...deleteButton].findIndex(
      (el) => +el.dataset.id === +deleteModalId
    );
    const row = deleteButton[+rowIndex].closest("tr");

    // remove row
    row.remove();
    deleteModal?.classList.remove("show-modal");

    // enable scrolling
    document.body.style.overflow = "auto";

    const successData = await response.json();

    // show an ALERT message
    bogoAlert(successData.message, "bg-red");
  } catch (error) {
    alert(error);
  }
});
