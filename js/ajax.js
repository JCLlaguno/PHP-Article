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
      throw new Error(`HTTP ERROR: ${errorData.message}`);
    }

    return await response.json();
  } catch (error) {
    console.error(error);
  }
};
export { ajaxRequest };
