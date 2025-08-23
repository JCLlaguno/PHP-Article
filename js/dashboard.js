import { ajaxRequest } from "./ajax.js";
import { renderPagination } from "./helpers.js";

// load total articles on dashboard
const dashboardArticlesCount = async () => {
  const articlesCardContent = document.querySelector(
    ".dashboard .articles-card-content"
  );
  // display count of total articles
  const status = 2; // get all articles
  const data = await ajaxRequest(`./getPaginatedArticles.php?status=${status}`);
  if (articlesCardContent) articlesCardContent.textContent = data.totalCount;
};
export { dashboardArticlesCount };

// DISPLAY paginated articles on dashboard
let limit = 8; // max records to display per page
const dashboardPaginateArticles = async (currentPage = 1, status = 0) => {
  // get paginated articles
  const data = await ajaxRequest(
    `./getPaginatedArticles.php?page=${currentPage}&limit=${limit}&status=${status}`
  );

  const paginationContainer = document.querySelector(".pagination");
  // show pagination buttons
  paginationContainer.style.display = "flex";

  // if article does not exceed 1 page
  if (data.totalPages === 1) paginationContainer.style.display = "none"; // hide pagination buttons

  const dashboardTable = document.querySelector(".dashboard tbody");
  dashboardTable.innerHTML = ""; // clear all existing rows

  // if no article matches filter, display a message
  if (data.totalCount === 0) {
    const tr = document.createElement("tr");
    // style the message
    tr.style.display = "block";
    tr.style.color = "var(--red)";
    tr.style.marginTop = "1rem";

    tr.innerHTML = `No articles found in this category.`;
    dashboardTable?.appendChild(tr);

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
        <td><span class="article-status-badge" style="color:${
          article.status === 1 ? "var(--green)" : "var(--maroon)"
        };">${article.status === 1 ? "Read" : "Unread"}</span></td>`;
      dashboardTable?.appendChild(tr);
    });
  }

  // when an article title is clicked, VIEW the article
  const articleTitle = document.querySelectorAll(
    ".dashboard table .article-title"
  );
  articleTitle.forEach((article) => {
    article.addEventListener("click", async (e) => {
      const viewArticleModal = document.querySelector(".view-article-modal");

      // SHOW view article modal
      viewArticleModal.classList.add("show");
      // disable scrolling on body
      document.body.style.overflow = "hidden";

      // get id from article
      const articleId = +e.target.closest("td").dataset.id;
      // get a single article
      const data = await ajaxRequest(`./getArticle.php?get_id=${articleId}`);

      // pass article id to checkbox element
      const checkbox = document.getElementById("view-article-checkbox");
      checkbox.setAttribute("data-id", articleId);
      // get checkbox status if checked/unchecked
      checkbox.checked = data.status ? true : false;

      // Fill form
      viewArticleModal.querySelector(".view-article-title h4").textContent =
        data.article_title;
      viewArticleModal.querySelector(".view-article-content").textContent =
        data.article_content;
    });
  });

  // render pagination and buttons
  renderPagination(
    data.page,
    data.totalPages,
    status,
    dashboardPaginateArticles
  );

  // currentPage = data.page;
};
export { dashboardPaginateArticles };

// handle status filter change
document.querySelector(".status-select")?.addEventListener("change", (e) => {
  const status = e.target.value; // 0 = unread, 1 = read, 2 = all
  const currentPage = 1; // go to first page
  dashboardPaginateArticles(currentPage, status); // reload filtered articles
});
