// LOAD a active user
const navUserPhoto = document.querySelector(".nav-user-photo");
const dashboardTitle = document.querySelector(".dashboard .dashboard-welcome");
const loadActiveUser = async () => {
  try {
    const response = await fetch(`./getUser.php`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json", // Sending JSON
      },
    });

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(`HTTP error ${errorData.message}`);
    }

    const data = await response.json();

    // Display active user photo on nav
    navUserPhoto.setAttribute("src", `${data.photo}`);
    // dashboardImg.setAttribute("src", `${data.photo}`);
    if (dashboardTitle)
      dashboardTitle.textContent = `Welcome! ${data.username
        .charAt(0)
        .toUpperCase()}${data.username.slice(1)}`;
  } catch (error) {
    console.error("Error loading user:", error);
  }
};
export { loadActiveUser };
