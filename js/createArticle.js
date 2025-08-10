import { bogoAlert } from "./script.js";

const createArticle = () => {
  const articles = document.querySelector(".articles");
  const newArticleBtn = document.querySelector(".new-btn-container .btn");
  const createArticleModal = document.querySelector(".create-article-modal");
  const createArticleForm = document.querySelector(".create-article-form");

  // show create article modal
  newArticleBtn?.addEventListener("click", () => {
    createArticleModal?.classList.add("show");
    document.body.style.overflow = "hidden";
  });

  // close create article modal when back is pressed
  const backButton = createArticleModal?.querySelector(
    ".form-btn-container .form-back-btn"
  );
  backButton?.addEventListener("click", (e) => {
    e.preventDefault();
    createArticleModal.classList.remove("show");
    document.body.style.overflow = "auto";
  });

  // when form is submitted
  createArticleForm?.addEventListener("submit", async function (e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    // Convert FormData to a plain JS object
    const data = Object.fromEntries(formData);

    try {
      const response = await fetch("./createArticle.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json", // Sending JSON
        },
        body: JSON.stringify(data), // send data as JSON
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.error);
      }
      const successData = await response.json();

      // close create article modal
      createArticleModal.classList.remove("show");

      // show an ALERT message
      bogoAlert(successData.message, "bg-blue", articles);

      // reload page after 2s
      setTimeout(() => {
        location.reload();
      }, 2000);
    } catch (error) {
      alert(error);
    }
  });
};

export { createArticle };
