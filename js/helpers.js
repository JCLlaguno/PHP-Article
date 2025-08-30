import { ajaxRequest } from "./ajax.js";
// custom ALERT message
const bogoAlert = (message, alertType = "bg-black", duration = false) => {
  const html = `
    <div class="alert">
        <div class="alert-content ${alertType}">
            <p class="alert-title">${message}</p>
        </div>
    </div>`;
  document.body.insertAdjacentHTML("afterbegin", html);

  const alert = document.querySelector(".alert");

  // close ALERT immediately if modal is clicked
  alert.addEventListener("click", () => alert.remove());

  // close ALERT after duration (optional)
  if (duration) setTimeout(() => alert.remove(), duration * 1000);
};
export { bogoAlert };

// function to RENDER pagination and buttons
const renderPagination = (page, totalPages, status, paginateArticles) => {
  page = +page; // convert data type to NUMBER (prevent string concatenation)

  const paginationContainer = document.querySelector(".pagination");
  paginationContainer.innerHTML = "";

  // Prev button
  const prevBtn = document.createElement("button");
  prevBtn.textContent = "Prev";
  prevBtn.disabled = page === 1;
  prevBtn.addEventListener("click", () => paginateArticles(page - 1, status));
  paginationContainer.appendChild(prevBtn);

  let start = Math.max(1, page - 2);
  let end = Math.min(totalPages, page + 2);

  const addPageButton = (i, current) => {
    const pageBtn = document.createElement("button");
    pageBtn.textContent = i;
    if (i === current) pageBtn.classList.add("active");
    pageBtn.addEventListener("click", () => paginateArticles(i, status));
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
  nextBtn.addEventListener("click", () => paginateArticles(page + 1, status));
  paginationContainer.appendChild(nextBtn);
};
export { renderPagination };

// VIEW an article
const viewArticle = (articleLink) => {
  articleLink.forEach((article) => {
    article.addEventListener("click", async (e) => {
      const viewArticleModal = document.querySelector(".view-article-modal");

      // SHOW view article modal
      viewArticleModal.classList.add("show");
      // disable scrolling on body
      document.body.style.overflow = "hidden";

      // get id from article
      const articleId = +e.target.closest("td").dataset.id;
      // get a single article
      const data = await ajaxRequest(
        `./getArticle.php?article-id=${articleId}`
      );

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
};
export { viewArticle };

const articleStatusSelect = (paginateArticles) => {
  // handle status filter change
  document.getElementById("status-select")?.addEventListener("change", (e) => {
    const status = e.target.value; // 0 = unread, 1 = read, 2 = all
    const currentPage = 1; // go to first page
    paginateArticles(currentPage, status); // reload filtered articles
  });
};
export { articleStatusSelect };

const formatDate = (dateStr) => {
  // Replace space with 'T' so JS can parse it as ISO8601
  const date = new Date(dateStr.replace(" ", "T"));
  const options = { year: "numeric", month: "short", day: "numeric" };
  return date.toLocaleDateString("en-US", options);
};
export { formatDate };
