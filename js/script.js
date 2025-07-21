"use strict";
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
hugerte?.init({
  selector: "#article-content",
  branding: false,
});
