// AJAX helper function
const ajaxRequest = async (url, options = {}) => {
  try {
    const response = await fetch(url, {
      headers: {
        "Content-Type": "application/json",
      },
      ...options,
    });

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(`HTTP error ${errorData.message}`);
    }

    return await response.json();
  } catch (error) {
    console.error("Error loading data:", error);
  }
};
export { ajaxRequest };
