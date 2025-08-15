// LOAD all articles
const loadAllArticles = async () => {
  try {
    const response = await fetch(`./loadAllArticles.php`);

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(`HTTP error ${errorData.message}`);
    }

    const data = await response.json();

    // load total users on dashboard
    document.querySelector(
      ".dashboard .articles-card-content"
    ).textContent = `${Object.keys(data).length}`;
  } catch (error) {
    console.error("Error loading all articles:", error);
  }
};

export { loadAllArticles };
