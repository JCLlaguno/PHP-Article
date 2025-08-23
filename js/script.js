import { navLoadActiveUser } from "./nav.js";
import {
  dashboardArticlesCount,
  dashboardPaginateArticles,
} from "./dashboard.js";
import {
  displayArticle,
  createArticle,
  updateArticleStatus,
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
  dashboardArticlesCount();
  dashboardPaginateArticles();
}

// NAV
// display logged in user image in nav
navLoadActiveUser();

// USERS
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

// CREATE article
createArticle();
// VIEW article
displayArticle();
// UPDATE article status
updateArticleStatus();
// UPDATE article
updateArticle();
// DELETE article
deleteArticle();
