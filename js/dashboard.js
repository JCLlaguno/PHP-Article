import { ajaxRequest } from "./ajax.js";
import {
  renderPagination,
  viewArticle,
  articleStatusSelect,
} from "./helpers.js";

// Display active username on dashboard Welcome
const dashboardWelcomeUser = async () => {
  const dashboardTitle = document.querySelector(
    ".dashboard .dashboard-welcome span"
  );
  // load active user (logged in user)
  const data = await ajaxRequest("./getUser.php");
  dashboardTitle.textContent = `${data.username
    .charAt(0)
    .toUpperCase()}${data.username.slice(1)}`;
};
export { dashboardWelcomeUser };

// display total users on dashboard card
const dashboardUsersCount = async () => {
  const data = await ajaxRequest(`./loadAllUsers.php`);

  const usersCardContent = document.querySelector(
    ".dashboard .users-card-content"
  );
  if (usersCardContent)
    usersCardContent.textContent = `${Object.keys(data).length}`;
};
export { dashboardUsersCount };

// display total articles on dashboard card
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
  if (dashboardTable) dashboardTable.innerHTML = ""; // clear all existing rows

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
        <td class="article-status"><span class="article-status-badge" style="color:${
          article.status === 1 ? "var(--green)" : "var(--maroon)"
        };">${article.status === 1 ? "Read" : "Unread"}</span></td>`;
      dashboardTable?.appendChild(tr);
    });
  }

  // when an article title is clicked, VIEW the article
  const articleTitle = document.querySelectorAll(
    ".dashboard table .article-title"
  );
  viewArticle(articleTitle);

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
articleStatusSelect(dashboardPaginateArticles);
