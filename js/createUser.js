import { bogoAlert } from "./script.js";
import { loadAllUsers } from "./loadAllUsers.js";

const createUser = () => {
  const users = document.querySelector(".users");
  const newUserBtn = document.querySelector(".new-btn-container .new-user-btn");
  const createUserModal = document.querySelector(".create-user-modal");
  const createUserForm = document.querySelector(".create-user-form");

  // show create user modal
  newUserBtn?.addEventListener("click", (e) => {
    e.preventDefault();
    createUserModal.classList.add("show");
    document.body.style.overflow = "hidden";
  });

  // close create user modal when back is pressed
  const backButton = createUserModal?.querySelector(
    ".form-btn-container .form-back-btn"
  );
  backButton?.addEventListener("click", (e) => {
    e.preventDefault();
    createUserModal.classList.remove("show");
    document.body.style.overflow = "auto";
  });

  // when form is SUBMITTED
  createUserForm?.addEventListener("submit", async function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    try {
      let response = await fetch("./createUser.php", {
        method: "POST",
        body: formData,
      });
      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message);
      }
      const successData = await response.json();
      // close create user modal
      createUserModal.classList.remove("show");

      document.body.style.overflow = "auto";

      // show an ALERT message
      bogoAlert(successData.message, "bg-blue", users);

      // load all users
      loadAllUsers();
    } catch (error) {
      alert(error.message);
    }
  });
};

export { createUser };
