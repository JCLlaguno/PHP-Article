import { dashboardArticlesCount } from "./dashboard.js";
import {
  displayArticle,
  displayPaginatedArticles,
  createArticle,
  updateArticle,
  deleteArticle,
} from "./article.js";
import {
  displayUsers,
  loadActiveUser,
  createUser,
  updateUser,
  deleteUser,
} from "./user.js";

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
dashboardArticlesCount();

// USERS
// LOAD a single user
loadActiveUser();
// Display all users
displayUsers();
// CREATE user
createUser();
// UPDATE user
updateUser();
// DELETE user
deleteUser();

// ARTICLES
// LOAD all articles
displayPaginatedArticles();
// CREATE article
createArticle();
// VIEW article
displayArticle();
// UPDATE article
updateArticle();
// DELETE article
deleteArticle();
