import { ajaxRequest } from "./ajax.js";
const paginationContainer = document.querySelector(".pagination");

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
let currentPage;
let limit = 8; // max records to display per page
const dashboardPaginateArticles = async (currentPage = 1, status = 0) => {
  console.log(status);
  // get paginated articles
  const data = await ajaxRequest(
    `./getPaginatedArticles.php?page=${currentPage}&limit=${limit}&status=${status}`
  );

  const dashboardTable = document.querySelector(".dashboard tbody");

  // if no article matches filter, display a message
  if (data.totalCount === 0) {
    const tr = document.createElement("tr");
    tr.textContent = `No articles found in this category.`;
    dashboardTable?.appendChild(tr);
    // hide pagination buttons
    paginationContainer.style.display = "none";
  }

  if (data.totalPages === 1) paginationContainer.style.display = "none";

  // show pagination buttons
  paginationContainer.style.display = "flex";

  dashboardTable.innerHTML = ""; // clear all existing rows
  data.data.forEach((article, i) => {
    const tr = document.createElement("tr");
    // LOAD data on users table
    tr.innerHTML = `
        <td>${(currentPage - 1) * limit + (i + 1)}</td>
        <td class="fixed-col" data-id=${article.id}><p>${
      article.article_title
    }</p></td>
        <td><span class="article-status-badge">${
          article.status === 1 ? "Read" : "Unread"
        }</span></td>`;
    dashboardTable?.appendChild(tr);
  });

  // open view article modal when an article is clicked
  const articleTitle = document.querySelectorAll(".dashboard .fixed-col");
  articleTitle.forEach((article) => {
    article.addEventListener("click", async (e) => {
      // when an article is CLICKED
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

  // render pagination
  renderPagination(data.page, data.totalPages, status);
  currentPage = data.page;
};

export { dashboardPaginateArticles };

// function to RENDER pagination and buttons
const renderPagination = (page, totalPages, status) => {
  paginationContainer.innerHTML = "";

  // Prev button
  const prevBtn = document.createElement("button");
  prevBtn.textContent = "Prev";
  prevBtn.disabled = page === 1;
  prevBtn.addEventListener("click", () =>
    dashboardPaginateArticles(page - 1, status)
  );
  paginationContainer.appendChild(prevBtn);

  // const maxVisible = 5; // how many page numbers to show around current
  let start = Math.max(1, page - 2);
  let end = Math.min(totalPages, page + 2);

  const addPageButton = (i, current) => {
    const pageBtn = document.createElement("button");
    pageBtn.textContent = i;
    if (i === current) pageBtn.classList.add("active");
    pageBtn.addEventListener("click", () =>
      dashboardPaginateArticles(i, status)
    );
    paginationContainer.appendChild(pageBtn);
  };

  if (start > 1) {
    addPageButton(1, page);
    if (start > 2) {
      const span = document.createElement("span");
      span.textContent = "...";
      paginationContainer.appendChild(span);
    }
  }

  for (let i = start; i <= end; i++) {
    addPageButton(i, page);
  }

  if (end < totalPages) {
    if (end < totalPages - 1) {
      const span = document.createElement("span");
      span.textContent = "...";
      paginationContainer.appendChild(span);
    }
    addPageButton(totalPages, page);
  }

  // Next button
  const nextBtn = document.createElement("button");
  nextBtn.textContent = "Next";
  nextBtn.disabled = page === totalPages;
  nextBtn.addEventListener("click", () =>
    dashboardPaginateArticles(page + 1, status)
  );
  paginationContainer.appendChild(nextBtn);
};

// handle status filter change
const statusSelect = document.querySelector(".status-select");
// if an option is selected
statusSelect?.addEventListener("change", (e) => {
  let status = e.target.value; // 0 = unread, 1 = read, 2 = all
  currentPage = 1; // go to first page
  dashboardPaginateArticles(currentPage, status); // reload filtered articles
});
