import { loadAllArticles } from "./loadAllArticles.js";
import { createUser } from "./createUser.js";
import { createArticle } from "./createArticle.js";
import { viewArticle } from "./viewArticle.js";
import { updateArticle } from "./updateArticle.js";
import { deleteArticle } from "./deleteArticle.js";
import { loadActiveUser } from "./loadActiveUser.js";
import { loadAllUsers } from "./loadAllUsers.js";
import { updateUser } from "./updateUser.js";
import { deleteUser } from "./deleteUser.js";

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

// custom ALERT message
const bogoAlert = (message, alertType = "bg-black", parentEl) => {
  const html = `
    <div class="alert">
        <div class="alert-content ${alertType}">
            <p class="alert-title">${message}</p>
        </div>
    </div>`;
  parentEl.insertAdjacentHTML("afterbegin", html);

  const alert = document.querySelector(".alert");

  // close ALERT immediately if modal is clicked
  alert.addEventListener("click", () => {
    alert.remove();
  });

  // close ALERT after 2 sec
  setTimeout(() => {
    alert.remove();
  }, 2000);
};

export { bogoAlert };

// DASHBOARD
// LOAD all articles
loadAllArticles();

// USERS
// LOAD a single user
loadActiveUser();
// LOAD all users
loadAllUsers();
// CREATE user
createUser();
// UPDATE user
updateUser();
// DELETE user
deleteUser();

// ARTICLES
// CREATE article
createArticle();
// VIEW article
viewArticle();
// UPDATE article
updateArticle();
// DELETE article
deleteArticle();
