// custom ALERT message
const bogoAlert = (message, alertType = "bg-black", parentEl) => {
  const html = `
    <div class="alert">
        <div class="alert-content ${alertType}">
            <p class="alert-title">${message}</p>
        </div>
    </div>`;
  parentEl.insertAdjacentHTML("afterbegin", html);

  const alert = document.querySelector(".alert");

  // close ALERT immediately if modal is clicked
  alert.addEventListener("click", () => {
    alert.remove();
  });

  // close ALERT after 2 sec
  setTimeout(() => {
    alert.remove();
  }, 2000);
};
export { bogoAlert };

// LOAD A SINGLE USER
const loadUser = async ($id) => {
  try {
    const body = $id ? JSON.stringify({ userid: +$id }) : null;
    const response = await fetch("./getUser.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json", // Sending JSON
      },
      body, // send data as JSON
    });

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(`HTTP error ${errorData.message}`);
    }

    return await response.json();
  } catch (error) {
    console.error("Error loading user:", error);
  }
};
export { loadUser };

// LOAD ALL USERS
const loadAllUsers = async () => {
  try {
    const response = await fetch(`./loadAllUsers.php`);

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(`HTTP error ${errorData.message}`);
    }

    return await response.json();
  } catch (error) {
    console.error("Error loading all users:", error);
  }
};
export { loadAllUsers };

// LOAD A SINGLE ARTICLE
const loadArticle = async (id) => {
  try {
    const response = await fetch(`./getArticle.php?get_id=${id}`); // send a GET request to getArticle.php

    if (!response.ok) throw new Error(`HTTP error ${response.status}`);

    return await response.json();
  } catch (error) {
    console.error("Error loading article:", error);
  }
};
export { loadArticle };

// LOAD ALL ARTICLES
const getPaginatedArticles = async (page = 1) => {
  try {
    const response = await fetch(
      `./getPaginatedArticles.php?page=${page}&limit=${8}`
    );

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(`HTTP error ${errorData.message}`);
    }
    return await response.json();
  } catch (error) {
    console.error("Error loading paginated articles:", error);
  }
};
export { getPaginatedArticles };
