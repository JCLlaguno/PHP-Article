import { bogoRequest } from "./ajax.js";

// load total articles on dashboard
const dashboardArticlesCount = async () => {
  const articlesCardContent = document.querySelector(
    ".dashboard .articles-card-content"
  );
  // display count of total articles
  const status = 2; // get all articles
  const data = await bogoRequest(`./getPaginatedArticles.php?status=${status}`);
  if (articlesCardContent) articlesCardContent.textContent = data.totalCount;
};
export { dashboardArticlesCount };

// DISPLAY paginated articles on dashboard
let currentPage, status;
let limit = 8; // max records to display per page
const dashboardPaginateArticles = async (currentPage = 1, status = 0) => {
  // get paginated articles
  const data = await bogoRequest(
    `./getPaginatedArticles.php?page=${currentPage}&limit=${limit}&status=${status}`
  );

  const dashboardArticleLists = document.getElementById(
    "dashboard-article-lists"
  );
  if (!dashboardArticleLists) return;

  dashboardArticleLists.innerHTML = ""; // reset list when dashboardPaginateArticles is called

  // if no article matches filter, display a message
  if (data.totalCount === 0) {
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

  // when an article is CLICKED
  const viewArticleModal = document.querySelector(".view-article-modal");
  data.data.forEach((data, i) => {
    const li = document.createElement("li");
    li.id = "dashboard-article"; // set element id
    li.setAttribute("data-id", data.id); // pass id from data to li element
    // compute global numbering across pages
    const number = (currentPage - 1) * limit + (i + 1);
    li.textContent = `${number}. ${data.article_title}`; // display title of an article
    dashboardArticleLists?.appendChild(li);

    // open view article modal when an article is clicked
    li.addEventListener("click", async (e) => {
      // SHOW view article modal
      viewArticleModal.classList.add("show");
      // disable scrolling on body
      document.body.style.overflow = "hidden";

      const articleId = +e.target.closest("li").dataset.id;
      // get a single article
      const data = await bogoRequest(`./getArticle.php?get_id=${articleId}`);
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
  renderPagination(data.page, data.totalPages);
  currentPage = data.page;
};

export { dashboardPaginateArticles };

// function to RENDER pagination and buttons
const renderPagination = (page, totalPages) => {
  const pagination = document.getElementById("pagination");
  pagination.innerHTML = "";

  // Prev button
  const prevBtn = document.createElement("button");
  prevBtn.textContent = "Prev";
  prevBtn.disabled = page === 1;
  prevBtn.addEventListener("click", () =>
    dashboardPaginateArticles(page - 1, status)
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
      dashboardPaginateArticles(i, status)
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
    dashboardPaginateArticles(page + 1, status)
  );
  pagination.appendChild(nextBtn);
};

// handle status filter change
const statusSelect = document.getElementById("statusSelect");
// if an option is selected
statusSelect?.addEventListener("change", (e) => {
  status = e.target.value; // 0 = unread, 1 = read, 2 = all
  currentPage = 1; // go to first page
  dashboardPaginateArticles(currentPage, status); // reload filtered articles
});
