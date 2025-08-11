import { bogoAlert } from "./script.js";
import { loadAllUsers } from "./loadAllUsers.js";

const updateUser = () => {
  const users = document.querySelector(".users");
  const updateBackButton = document.querySelector(
    ".update-user-form .form-back-btn"
  );
  const updateUserModal = document.querySelector(".update-user-modal");
  const updateUserForm = updateUserModal?.querySelector(".update-user-form");

  // close update user modal when BACK is pressed
  updateBackButton?.addEventListener("click", () => {
    updateUserModal.classList.remove("show");
    document.body.style.overflow = "auto";
    
    // clear form fields
    updateUserForm.reset();
  });

  // if form is SUBMITTED
  updateUserForm?.addEventListener("submit", async function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    try {
      const response = await fetch("./updateUser.php", {
        method: "POST",
        body: formData,
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.error);
      }

      const successData = await response.json();

      // close create user modal
      updateUserModal.classList.remove("show");

      // show an ALERT message
      bogoAlert(successData.message, "bg-green", users);

      // load all users
      loadAllUsers();

      // clear form fields
      updateUserForm.reset();
    } catch (error) {
      alert(error);
    }
  });
};

export { updateUser };
