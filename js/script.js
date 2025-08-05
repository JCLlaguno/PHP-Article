import { createUser } from "./createUser.js";
import { createArticle } from "./createArticle.js";
import { viewArticle } from "./viewArticle.js";
import { updateArticle } from "./updateArticle.js";
import { deleteArticle } from "./deleteArticle.js";
import { loadAllUsers } from "./loadAllUsers.js";
import { deleteUser } from "./deleteUser.js";

// SHOW/HIDE mobile menu
const mobileToggle = document.querySelector(".mobile-toggle-btn");
const mobileMenu = document.querySelector(".mobile-menu");
const mobileMenuCloseBtn = document.querySelector(
  ".mobile-menu .mobile-toggle-btn"
);
mobileToggle?.addEventListener("click", () => {
  mobileMenu?.classList.toggle("show-menu");
});
mobileMenuCloseBtn?.addEventListener("click", () => {
  mobileMenu?.classList.toggle("show-menu");
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

// LOAD all users
loadAllUsers();
// CREATE user
createUser();
// Delete user
deleteUser();

// CREATE article
createArticle();
// VIEW article
viewArticle();
// UPDATE article
updateArticle();
// DELETE article
deleteArticle();
