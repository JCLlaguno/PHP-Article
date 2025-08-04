import { bogoAlert } from "./script.js";

// we get ID 2 times
// 1. from URL (GET) request to laod articles initially
// 2. from form (PUT) to update articles
const updateArticle = () => {
  const actionUpdateButton = document.querySelectorAll(".action-update-btn");
  const updateBackButton = document.querySelector(
    ".update-article-form .form-back-btn"
  );
  const updateArticleModal = document.querySelector(".update-article-modal");
  const updateArticleForm = updateArticleModal?.querySelector(
    ".update-article-form"
  );
  const updateArticleId =
    updateArticleForm?.querySelector("#update-article-id"); // id from UPDATE FORM

  // LOAD article
  const loadArticle = async (id) => {
    try {
      const response = await fetch(`./getArticle.php?get_id=${id}`); // send a GET request to getArticle.php

      if (!response.ok) throw new Error(`HTTP error ${response.status}`);

      const data = await response.json();

      // Fill form
      updateArticleForm.querySelector(".article-title").value =
        data.article_title || "";
      updateArticleForm.querySelector(".article-content").value =
        data.article_content || "";
    } catch (error) {
      console.error("Error loading article:", error);
    }
  };

  // // if action UPDATE btn is CLICKED
  actionUpdateButton.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();

      // SHOW update article form
      updateArticleModal.classList.add("show");
      // disable scroll on articles
      document.body.style.overflow = "hidden";
      // enable scroll on update modal
      updateArticleModal.style.overflow = "scroll";
      // pass row id from table to UPDATE form input
      updateArticleId?.setAttribute("value", `${btn.dataset.id}`);
      // load selected article
      loadArticle(btn.dataset.id);
    });
  });

  // close update article modal when back is pressed
  updateBackButton?.addEventListener("click", () => {
    updateArticleModal.classList.remove("show");
    document.body.style.overflow = "auto";
  });

  // if form is SUBMITTED
  updateArticleModal?.addEventListener("submit", async (e) => {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    // Convert FormData to a plain JS object
    const data = Object.fromEntries(formData);

    try {
      const response = await fetch("./updateArticle.php", {
        method: "PUT",
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
      updateArticleModal.classList.remove("show");

      // show an ALERT message
      bogoAlert(successData.message, "bg-green");
    } catch (error) {
      alert(error);
    }
  });
};

export { updateArticle };
