import { bogoAlert } from "./helpers.js";
import { ajaxRequest } from "./ajax.js";
import {
  viewArticle,
  renderPagination,
  articleStatusSelect,
  formatDate,
} from "./helpers.js";

// get status select dropdown element
const statusSelect = document.getElementById("status-select");

// DISPLAY paginated articles on dashboard
let limit = 8; // max records to display per page
const paginateArticles = async (currentPage = 1, status = 0) => {
  // get paginated articles
  const data = await ajaxRequest(
    `./getPaginatedArticles.php?page=${currentPage}&limit=${limit}&status=${status}`
  );

  const paginationContainer = document.querySelector(".pagination");
  // show pagination buttons
  paginationContainer.style.display = "flex";

  // if article does not exceed 1 page
  if (data.totalPages === 1) paginationContainer.style.display = "none"; // hide pagination buttons

  const articleTable = document.querySelector(".articles tbody");
  if (!articleTable) return;
  articleTable.innerHTML = ""; // clear all existing rows

  // if no article matches filter, display a message
  if (data.totalCount === 0) {
    const tr = document.createElement("tr");
    // style the message
    tr.style.display = "block";
    tr.style.color = "var(--maroon)";
    tr.style.marginTop = "1rem";

    tr.textContent = `No articles found in this category.`;
    articleTable?.appendChild(tr);

    // hide pagination buttons
    paginationContainer.style.display = "none";
  } else {
    data.data.forEach((article, i) => {
      const tr = document.createElement("tr");
      // LOAD data on users table
      tr.innerHTML = `
        <td>${(currentPage - 1) * limit + (i + 1)}</td>
        <td class="article-title" data-id=${article.id}><p>${
        article.article_title
      }</p></td>
        <td class="article-status"><span class="article-status-badge" style="color:${
          article.status === 1 ? "var(--green)" : "var(--maroon)"
        };">${article.status === 1 ? "Read" : "Unread"}</span></td>
        <td class="article-created"><p>${formatDate(
          article.date_created
        )}</p></td>
        <td>
            <div class="action-container">
                <a class="btn bg-green action-update-btn" data-id="${
                  article.id
                }" alt="Update"><img src="./img/edit.svg" alt="Edit"></a>
                <a class="btn bg-red action-delete-btn article-delete-btn" data-id="${
                  article.id
                }" alt="Delete"><img src="./img/delete.svg" alt="Delete"></a>
            </div>
        </td>
      `;

      articleTable?.appendChild(tr);
    });
  }

  // when an article title is clicked, VIEW the article
  const articleTitle = document.querySelectorAll(
    ".articles table .article-title"
  );
  viewArticle(articleTitle);

  // handle UPDATE button click
  const actionUpdateBtn = document.querySelectorAll(".action-update-btn");
  const updateArticleModal = document.querySelector(".update-article-modal");
  const updateArticleForm = updateArticleModal.querySelector(
    ".update-article-form"
  );
  const updateArticleId = updateArticleForm.querySelector("#update-article-id"); // id from UPDATE FORM

  // attach and event listener to each update button
  actionUpdateBtn.forEach((btn) => {
    btn.addEventListener("click", async (e) => {
      e.preventDefault();

      // SHOW update article form
      updateArticleModal.classList.add("show");
      // disable scroll on body
      document.body.style.overflow = "hidden";
      // enable scroll on update modal
      if (updateArticleModal) updateArticleModal.style.overflow = "scroll";
      // pass row id from table for updating article
      updateArticleId.setAttribute("value", `${btn.dataset.id}`);
      // get selected article
      const data = await ajaxRequest(
        `./getArticle.php?article-id=${+btn.dataset.id}`
      );
      // Fill update form
      updateArticleForm.querySelector(".article-title").value =
        data["article_title"];
      // Fill update form
      updateArticleForm.querySelector(".article-content").value =
        data["article_content"];
    });
  });

  // handle action DELETE button click
  const deleteBtn = document.querySelectorAll(".articles .action-delete-btn");
  const deleteModal = document.querySelector(".delete-modal");
  const deleteModalId = document.getElementById("delete-id");

  // attach and event listener to each delete button
  deleteBtn.forEach((btn) => {
    btn.addEventListener("click", () => {
      // show custom DELETE modal
      deleteModal.classList.toggle("show-modal");
      // disable scrolling
      document.body.style.overflow = "hidden";
      // pass row id from table to custom DELETE modal input
      deleteModalId.setAttribute("value", `${btn.dataset.id}`);
    });
  });

  // render pagination and buttons
  renderPagination(data.page, data.totalPages, status, paginateArticles);

  // show pagination page info
  document.getElementById("page-info").textContent =
    data.totalCount > 0 ? `Page ${data.page} of ${data.totalPages}` : null;
};
export { paginateArticles };

// handle status filter change
articleStatusSelect(paginateArticles);

// CREATE article
export function createArticle() {
  const newArticleBtn = document.querySelector(".articles .new-btn");
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
    createArticleForm.reset(); // reset form
  });

  // when form is submitted
  createArticleForm.addEventListener("submit", async function (e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    // Convert FormData to a plain JS object
    const data = Object.fromEntries(formData);

    try {
      const successData = await ajaxRequest("./createArticle.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json", // Sending JSON
        },
        body: JSON.stringify(data), // send data as JSON
      });

      // close create article modal
      createArticleModal.classList.remove("show");

      // enable scroll on body
      document.body.style.overflow = "auto";

      // show an ALERT message
      bogoAlert(successData.message, "bg-blue", 2);

      // set status filter value to unread
      statusSelect.selectedIndex = 0;

      // reload paginated articles
      paginateArticles();

      // clear form fields
      createArticleForm.reset();
    } catch (error) {
      bogoAlert(error, "bg-red");
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
      const data = await ajaxRequest(
        `./getArticle.php?article-id=${+btn.dataset.id}`
      );

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

// UPDATE checkbox in VIEW articles
export async function updateCheckbox(paginateArticles) {
  // get checkbox element
  const checkbox = document.getElementById("view-article-checkbox");

  // if checkbox is checked / unchecked
  checkbox?.addEventListener("change", async function () {
    const articleId = this.dataset.id; // get checkbox id
    const status = this.checked ? 1 : 0;

    // update article status in db
    await ajaxRequest("./updateArticle.php", {
      method: "PATCH",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ "update-article-id": articleId, status }),
    });

    // set status filter value to unread
    statusSelect.selectedIndex = 0;

    // display paginated articles (page = 1, status = 0 (unread))
    paginateArticles();
  });
}

// UPDATE article
export function updateArticle() {
  const updateBackButton = document.querySelector(
    ".update-article-form .form-back-btn"
  );
  const updateArticleModal = document.querySelector(".update-article-modal");
  const updateArticleForm = updateArticleModal.querySelector(
    ".update-article-form"
  );

  // close update article modal when back is pressed
  updateBackButton.addEventListener("click", () => {
    updateArticleModal.classList.remove("show");
    document.body.style.overflow = "auto";
    updateArticleForm.reset(); // reset form
  });

  // if form is SUBMITTED
  updateArticleModal.addEventListener("submit", async (e) => {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    // Convert FormData to a plain JS object
    const data = Object.fromEntries(formData);

    try {
      const successData = await ajaxRequest("./updateArticle.php", {
        method: "PUT",
        headers: {
          "Content-Type": "application/json", // Sending JSON
        },
        body: JSON.stringify(data), // send data as JSON
      });

      if (successData.updated) {
        // close create user modal
        updateArticleModal.classList.remove("show");

        // set status filter value to unread
        statusSelect.selectedIndex = 0;

        // load all users
        paginateArticles();

        // clear form fields
        updateArticleForm.reset();
      }

      // show an ALERT message
      bogoAlert(
        successData.message,
        `${successData.updated ? "bg-green" : "bg-red"}`,
        2
      );
    } catch (error) {
      bogoAlert(error, "bg-red");
    }
  });
}

// DELETE an article
export function deleteArticle() {
  const deleteModal = document.querySelector(".delete-modal");
  const deleteArticleForm = document.querySelector(".delete-article-form");
  const deleteModalCancel = document.querySelector(".modal-cancel-btn");
  const deleteBtn = document.querySelectorAll(".articles .action-delete-btn");

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

    const form = e.target;
    const formData = new FormData(form);
    // Convert FormData to a plain JS object
    const deleteId = Object.fromEntries(formData);

    try {
      const successData = await ajaxRequest("./deleteArticle.php", {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json", // Sending JSON
        },
        body: JSON.stringify(deleteId), // send data as JSON
      });

      // hide custom DELETE modal
      deleteModal.classList.remove("show-modal");
      // enable scrolling
      document.body.style.overflow = "auto";

      // show an ALERT message
      bogoAlert(successData.message, "bg-red", 2);

      // set status filter value to unread
      statusSelect.selectedIndex = 0;

      // load paginated articles
      paginateArticles();
    } catch (error) {
      bogoAlert(error, "bg-red");
    }
  });
}
