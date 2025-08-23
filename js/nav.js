import { ajaxRequest } from "./ajax.js";
// LOAD a active user
const navUserPhoto = document.querySelector(".nav-user-photo");
const dashboardTitle = document.querySelector(".dashboard .dashboard-welcome");

const navLoadActiveUser = async () => {
  // load active user (logged in user)
  const data = await ajaxRequest("./getUser.php");
  // Display active user photo on nav
  navUserPhoto.setAttribute("src", `${data.photo}`);

  // Display active username on dashboard Welcome
  if (dashboardTitle)
    dashboardTitle.textContent = `Welcome! ${data.username
      .charAt(0)
      .toUpperCase()}${data.username.slice(1)}`;
};
export { navLoadActiveUser };
