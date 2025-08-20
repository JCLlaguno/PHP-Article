import { getPaginatedArticles } from "./helpers.js";

// load total articles on dashboard
const dashboardArticlesCount = async () => {
  const articlesCardContent = document.querySelector(
    ".dashboard .articles-card-content"
  );
  const data = await getPaginatedArticles();
  if (articlesCardContent) articlesCardContent.textContent = data.totalCount;
};
export { dashboardArticlesCount };
