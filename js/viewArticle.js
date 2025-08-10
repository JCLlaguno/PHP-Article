const viewArticle = () => {
  const actionViewButton = document.querySelectorAll(".action-view-btn");
  const viewArticleModal = document.querySelector(".view-article-modal");
  const viewArticleCloseButton =
    viewArticleModal?.querySelector(".close-article-btn");

  // LOAD article
  const loadArticle = async (id) => {
    try {
      const response = await fetch(`./getArticle.php?get_id=${id}`); // send a GET request to getArticle.php

      if (!response.ok) throw new Error(`HTTP error ${response.status}`);

      const data = await response.json();

      // Fill form
      viewArticleModal.querySelector(".view-article-title h4").textContent =
        data.article_title || "";
      viewArticleModal.querySelector(".view-article-content").textContent =
        data.article_content || "";
    } catch (error) {
      console.error("Error loading article:", error);
    }
  };

  // If action VIEW button is CLICKED
  actionViewButton?.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      const viewId = +btn.dataset.id;
      //   SHOW view article modal
      viewArticleModal.classList.add("show");
      // disable scrolling on body
      document.body.style.overflow = "hidden";

      // load selected article
      loadArticle(viewId);
    });
  });

  // if close (X) button is CLICKED
  viewArticleCloseButton?.addEventListener("click", (e) => {
    e.preventDefault();
    // HIDE view article modal
    viewArticleModal.classList.remove("show");
    // enable scrolling on body
    document.body.style.overflow = "auto";
  });
};

export { viewArticle };
