import { bogoAlert, loadArticle, getPaginatedArticles } from "./helpers.js";

// DISPLAY paginated articles on dashboard
let currentPage;
let status;
export async function displayPaginatedArticles(currentPage, status) {
  const data = await getPaginatedArticles(currentPage, status);

  const dashboardArticleLists = document.getElementById(
    "dashboard-article-lists"
  );
  if (!dashboardArticleLists) return;
  dashboardArticleLists.innerHTML = "";
  if (data.totalCount === 0) {
    // display a message
    const li = document.createElement("li");
    li.textContent = `No articles found in this category.`;
    dashboardArticleLists?.appendChild(li);
    // hide pagination buttons
    document.getElementById("pagination").style.display = "none";
  } else {
    // show pagination buttons
    document.getElementById("pagination").style.display = "flex";
  }
  if (data.totalPages === 1)
    document.getElementById("pagination").style.display = "none";
  data.data.forEach((data, i) => {
    const li = document.createElement("li");
    li.textContent = `${i + 1}. ${data.article_title}`;
    dashboardArticleLists?.appendChild(li);
  });
  // render pagination
  renderPagination(data.page, data.totalPages);
  currentPage = data.page;
  // show pagination buttons
}

// function to RENDER pagination and buttons
const renderPagination = (page, totalPages) => {
  const pagination = document.getElementById("pagination");
  pagination.innerHTML = "";

  // Prev button
  const prevBtn = document.createElement("button");
  prevBtn.textContent = "Prev";
  prevBtn.disabled = page === 1;
  prevBtn.addEventListener("click", () =>
    displayPaginatedArticles(page - 1, status)
  );
  pagination.appendChild(prevBtn);

  // const maxVisible = 5; // how many page numbers to show around current
  let start = Math.max(1, page - 2);
  let end = Math.min(totalPages, page + 2);

  const addPageButton = (i, current) => {
    const pageBtn = document.createElement("button");
    pageBtn.textContent = i;
    if (i === current) pageBtn.classList.add("active");
    pageBtn.addEventListener("click", () =>
      displayPaginatedArticles(i, status)
    );
    pagination.appendChild(pageBtn);
  };

  if (start > 1) {
    addPageButton(1, page);
    if (start > 2) {
      const span = document.createElement("span");
      span.textContent = "...";
      pagination.appendChild(span);
    }
  }

  for (let i = start; i <= end; i++) {
    addPageButton(i, page);
  }

  if (end < totalPages) {
    if (end < totalPages - 1) {
      const span = document.createElement("span");
      span.textContent = "...";
      pagination.appendChild(span);
    }
    addPageButton(totalPages, page);
  }

  // Next button
  const nextBtn = document.createElement("button");
  nextBtn.textContent = "Next";
  nextBtn.disabled = page === totalPages;
  nextBtn.addEventListener("click", () =>
    displayPaginatedArticles(page + 1, status)
  );
  pagination.appendChild(nextBtn);
};

// Handle role filter change
const statusSelect = document.getElementById("statusSelect");
statusSelect?.addEventListener("change", (e) => {
  status = e.target.value; // 3 = all, 0 = unread, 1 = read
  currentPage = 1; // go to first page
  displayPaginatedArticles(currentPage, status); // reload filtered articles
});

// CREATE article
export function createArticle() {
  const articles = document.querySelector(".articles");
  const newArticleBtn = document.querySelector(".new-btn-container .btn");
  const createArticleModal = document.querySelector(".create-article-modal");
  const createArticleForm = document.querySelector(".create-article-form");

  // show create article modal
  newArticleBtn?.addEventListener("click", () => {
    createArticleModal?.classList.add("show");
    document.body.style.overflow = "hidden";
  });

  // close create article modal when back is pressed
  const backButton = createArticleModal?.querySelector(
    ".form-btn-container .form-back-btn"
  );
  backButton?.addEventListener("click", (e) => {
    e.preventDefault();
    createArticleModal.classList.remove("show");
    document.body.style.overflow = "auto";
  });

  // when form is submitted
  createArticleForm?.addEventListener("submit", async function (e) {
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
      bogoAlert(successData.message, "bg-blue", articles);

      // reload page after 2s
      setTimeout(() => {
        location.reload();
      }, 2000);
    } catch (error) {
      alert(error);
    }
  });
}

// VIEW an article
export async function displayArticle() {
  const actionViewButton = document.querySelectorAll(".action-view-btn");
  const viewArticleModal = document.querySelector(".view-article-modal");
  const viewArticleCloseButton =
    viewArticleModal?.querySelector(".close-article-btn");

  // If action VIEW button is CLICKED
  actionViewButton?.forEach((btn) => {
    btn.addEventListener("click", async (e) => {
      e.preventDefault();
      //   SHOW view article modal
      viewArticleModal.classList.add("show");
      // disable scrolling on body
      document.body.style.overflow = "hidden";

      // load selected article
      const data = await loadArticle(+btn.dataset.id);

      // Fill form
      viewArticleModal.querySelector(".view-article-title h4").textContent =
        data.article_title || "";
      viewArticleModal.querySelector(".view-article-content").textContent =
        data.article_content || "";
    });
  });

  // if close (X) button is CLICKED
  viewArticleCloseButton?.addEventListener("click", (e) => {
    e.preventDefault();
    // HIDE view article modal
    viewArticleModal.classList.remove("show");
    // enable scrolling on body
    document.body.style.overflow = "auto";

    // RESET form
    viewArticleModal.querySelector(".view-article-title h4").textContent = "";
    viewArticleModal.querySelector(".view-article-content").textContent = "";
  });
}

// UPDATE article
export function updateArticle() {
  const articles = document.querySelector(".articles");
  const actionUpdateButton = document.querySelectorAll(".action-update-btn");
  const updateBackButton = document.querySelector(
    ".update-article-form .form-back-btn"
  );
  const updateArticleModal = document.querySelector(".update-article-modal");
  const updateArticleForm = updateArticleModal?.querySelector(
    ".update-article-form"
  );
  const updateArticleId =
    updateArticleForm?.querySelector("#update-article-id"); // id from UPDATE FORM

  // LOAD article
  const loadArticle = async (id) => {
    try {
      const response = await fetch(`./getArticle.php?get_id=${id}`); // send a GET request to getArticle.php

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

  // // if action UPDATE btn is CLICKED (TEMPORARY)
  actionUpdateButton.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();

      // SHOW update article form
      updateArticleModal.classList.add("show");
      // disable scroll on articles
      document.body.style.overflow = "hidden";
      // enable scroll on update modal
      updateArticleModal.style.overflow = "scroll";
      // pass row id from table to UPDATE form input
      updateArticleId?.setAttribute("value", `${btn.dataset.id}`);
      // load selected article
      loadArticle(btn.dataset.id);
    });
  });

  // close update article modal when back is pressed
  updateBackButton?.addEventListener("click", () => {
    updateArticleModal.classList.remove("show");
    document.body.style.overflow = "auto";
    updateArticleForm.reset();
  });

  // if form is SUBMITTED
  updateArticleModal?.addEventListener("submit", async (e) => {
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
      bogoAlert(successData.message, "bg-green", articles);

      // reload page after 2s
      setTimeout(() => {
        location.reload();
      }, 2000);
    } catch (error) {
      alert(error);
    }
  });
}

// DELETE an article
export function deleteArticle() {
  const articles = document.querySelector(".articles");
  const deleteButton = document.querySelectorAll(
    ".articles .action-delete-btn"
  );
  const deleteModal = document.querySelector(".delete-modal");
  const deleteArticleForm = document.querySelector(".delete-article-form");
  const deleteModalCancel = document.querySelector(".modal-cancel-btn");
  const deleteModalId = document.getElementById("delete-id");

  // if action delete btn is CLICKED
  deleteButton?.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      // show custom DELETE modal
      deleteModal?.classList.toggle("show-modal");
      // disable scrolling
      document.body.style.overflow = "hidden";
      // pass row id from table to custom DELETE modal input
      deleteModalId?.setAttribute("value", `${btn.dataset.id}`);
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
  deleteArticleForm?.addEventListener("submit", async (e) => {
    e.preventDefault(); // Prevent default form submission

    // const deleteId = deleteModalId.value; // get ID from delete Modal
    const form = e.target;
    const formData = new FormData(form);
    // Convert FormData to a plain JS object
    const deleteId = Object.fromEntries(formData);

    try {
      const response = await fetch("deleteArticle.php", {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json", // Sending JSON
        },
        body: JSON.stringify(deleteId), // send data as JSON
      });

      if (!response.ok) throw new Error(await response.json().error);

      // find row containing the delete button
      const rowIndex = [...deleteButton].findIndex(
        (el) => +el.dataset.id === +deleteId["delete-id"]
      );
      const row = deleteButton[+rowIndex].closest("tr");

      // remove row
      row.remove();
      deleteModal?.classList.remove("show-modal");

      // enable scrolling
      document.body.style.overflow = "auto";

      const successData = await response.json();

      // show an ALERT message
      bogoAlert(successData.message, "bg-red", articles);
    } catch (error) {
      alert(error);
    }
  });
}
