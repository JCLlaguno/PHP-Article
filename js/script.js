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
import { bogoAlert } from "./helpers.js";
import { ajaxRequest } from "./ajax.js";

// LOGIN
const loginForm = document.querySelector(".login-form");
loginForm?.reset(); // reset login form
// if login form is SUBMITTED
loginForm?.addEventListener("submit", async function (e) {
  e.preventDefault(); // Prevent default form submission

  const form = e.target;
  const formData = new FormData(form);

  try {
    const successData = await ajaxRequest("./login.php", {
      method: "POST",
      body: formData, // send data as JSON
    });

    // if request returned success (true), redirect to index page
    if (successData.success) window.location.href = successData.redirect;
  } catch (error) {
    bogoAlert(error, "bg-red", 2);
  }
});

// // SHOW/HIDE mobile menu
// const mobileToggle = document.querySelector(".nav-left .mobile-toggle-btn");
// const mobileMenu = document.querySelector(".mobile-menu");
// const mobileMenuCloseBtn = document.querySelector(
//   ".mobile-menu .mobile-toggle-btn"
// );
// mobileToggle?.addEventListener("click", () => {
//   mobileMenu?.classList.add("show-menu");
//   document.body.style.overflow = "hidden";
// });
// mobileMenuCloseBtn?.addEventListener("click", () => {
//   mobileMenu?.classList.remove("show-menu");
//   document.body.style.overflow = "auto";
// });

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
