import { ajaxRequest } from "./ajax.js";
// LOAD a active user
const navUserPhoto = document.querySelector(".nav-user-photo");

const navLoadActiveUser = async () => {
  // load active user (logged in user)
  const data = await ajaxRequest("./getUser.php");
  // Display active user photo on nav
  navUserPhoto.setAttribute("src", `${data.photo}`);
};
export { navLoadActiveUser };
