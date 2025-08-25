import { dashboardPaginateArticles } from "./dashboard.js";
import {
  paginateArticles,
  displayArticle,
  createArticle,
  updateCheckbox,
  updateArticle,
  deleteArticle,
} from "./article.js";
import { displayUsers, createUser, updateUser, deleteUser } from "./user.js";

// SHOW/HIDE mobile menu
const mobileToggle = document.querySelector(".nav-left .mobile-toggle-btn");
const mobileMenu = document.querySelector(".mobile-menu");
const mobileMenuCloseBtn = document.querySelector(
  ".mobile-menu .mobile-toggle-btn"
);
mobileToggle?.addEventListener("click", () => {
  mobileMenu?.classList.add("show-menu");
  document.body.style.overflow = "hidden";
});
mobileMenuCloseBtn?.addEventListener("click", () => {
  mobileMenu?.classList.remove("show-menu");
  document.body.style.overflow = "auto";
});

// DASHBOARD
if (document.querySelector(".dashboard")) {
  dashboardPaginateArticles();
  // UPDATE view article status
  updateCheckbox(dashboardPaginateArticles);
}

// USERS
if (document.querySelector(".users")) {
  // Display all users
  displayUsers();
  // CREATE user
  createUser();
  // UPDATE user
  updateUser();
  // DELETE user
  deleteUser();
}

// ARTICLES
if (document.querySelector(".articles")) {
  // display paginated articles
  paginateArticles();
  // CREATE article
  createArticle();
  // UPDATE view article status
  updateCheckbox(paginateArticles);
  // UPDATE article
  updateArticle();
  // DELETE article
  deleteArticle();
}
// VIEW article (also needed in dashboard)
displayArticle();
