import { bogoAlert } from "./script.js";
import { loadAllUsers } from "./loadAllUsers.js";

const deleteUser = () => {
  const users = document.querySelector(".users");
  const deleteModal = document.querySelector(".delete-modal");
  const deleteUserForm = document.querySelector(".delete-user-form");
  const deleteModalCancel = document.querySelector(".modal-cancel-btn");

  // if NO is selected in modal
  deleteModalCancel?.addEventListener("click", () => {
    // hide custom DELETE modal
    deleteModal?.classList.remove("show-modal");
    // enable scrolling
    document.body.style.overflow = "auto";
  });

  // if delete form is SUBMITTED
  deleteUserForm?.addEventListener("submit", async (e) => {
    e.preventDefault(); // Prevent default form submission

    const form = e.target;
    console.log(e.target);
    const formData = new FormData(form);
    // Convert FormData to a plain JS object
    const deleteId = Object.fromEntries(formData);

    try {
      const response = await fetch("./deleteUser.php", {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json", // Sending JSON
        },
        body: JSON.stringify(deleteId), // send data as JSON
      });

      if (!response.ok) throw new Error(await response.json().error);

      // hide custom DELETE modal
      deleteModal?.classList.remove("show-modal");
      // enable scrolling
      document.body.style.overflow = "auto";

      const successData = await response.json();

      // show an ALERT message
      bogoAlert(successData.message, "bg-red", users);

      // load all users
      loadAllUsers();
    } catch (error) {
      alert(error);
    }
  });
};

export { deleteUser };
