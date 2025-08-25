// AJAX helper function
const ajaxRequest = async (url, options = {}) => {
  try {
    // remove forced JSON header if body is FormData
    const isFormData = options.body instanceof FormData;
    const response = await fetch(url, {
      headers: isFormData ? undefined : { "Content-Type": "application/json" },
      ...options,
    });

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message);
    }

    return await response.json();
  } catch (error) {
    throw error;
  }
};
export { ajaxRequest };
