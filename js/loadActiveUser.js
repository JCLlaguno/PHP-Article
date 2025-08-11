// LOAD a single user
const navUserPhoto = document.querySelector(".nav-user-photo");
const loadActiveUser = async () => {
  try {
    const response = await fetch(`./getUser.php`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json", // Sending JSON
      },
    });

    if (!response.ok) throw new Error(`HTTP error ${response.status}`);

    const data = await response.json();

    // Display active user photo on nav
    navUserPhoto.setAttribute("src", `${data.photo}`);
  } catch (error) {
    console.error("Error loading article:", error);
  }
};
export { loadActiveUser };
