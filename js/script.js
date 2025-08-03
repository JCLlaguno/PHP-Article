import { createArticle } from "./createArticle.js";
import { updateArticle } from "./updateArticle.js";
import { deleteArticle } from "./deleteArticle.js";

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
const bogoAlert = (message, alertType = "bg-black") => {
  const html = `
    <div class="alert">
        <div class="alert-content ${alertType}">
            <p class="alert-title">${message}</p>
        </div>
    </div>`;
  const articles = document.querySelector(".articles");
  articles.insertAdjacentHTML("afterbegin", html);

  const alert = document.querySelector(".alert");

  // close ALERT immediately if modal is clicked
  alert.addEventListener("click", () => {
    alert.remove();
    window.location.reload();
  });

  // close ALERT after 2 sec
  setTimeout(() => {
    alert.remove();
    window.location.reload();
  }, 2000);
};

export { bogoAlert };

// CREATE article
createArticle();
// UPDATE article
updateArticle();
// DELETE article
deleteArticle();
