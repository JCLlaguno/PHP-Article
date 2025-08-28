import { bogoAlert } from "./helpers.js";
import { ajaxRequest } from "./ajax.js";

// DISPLAY all users
const displayUsers = async () => {
  // get all users from db
  const data = await ajaxRequest(`./loadAllUsers.php`);
  const usersTable = document.querySelector(".users .users-table tbody");
  if (usersTable) usersTable.innerHTML = ""; // clear all existing rows
  data.forEach((user) => {
    const tr = document.createElement("tr");
    // LOAD data on users table
    tr.innerHTML = `
        <td>${user.id}</td>
        <td class="user-photo-container"><img class="user-photo" src="${user.photo}"></td>
        <td>${user.username}</td>
        <td>
            <div class="action-container">
                <a class="btn bg-green action-update-btn" data-id="${user.id}"><img src="./img/edit.svg" alt="Edit"></a>
                <a class="btn bg-red action-delete-btn user-delete-btn" data-id="${user.id}"><img src="./img/delete.svg" alt="Edit"></a>
            </div>
        </td>`;
    usersTable?.appendChild(tr);
  });

  // handle UPDATE button click
  const actionUpdateBtn = document.querySelectorAll(".action-update-btn");
  const updateUserModal = document.querySelector(".update-user-modal");
  const updateUserForm = updateUserModal?.querySelector(".update-user-form");
  const updateuserId = updateUserForm?.querySelector("#update-user-id"); // id from UPDATE FORM

  // if action UPDATE btn is pressed
  actionUpdateBtn.forEach((btn) => {
    btn.addEventListener("click", async (e) => {
      e.preventDefault();

      updateUserForm.reset();

      // SHOW update user form
      updateUserModal?.classList.add("show");
      // disable scroll on body
      document.body.style.overflow = "hidden";
      // enable scroll on update modal
      if (updateUserModal) updateUserModal.style.overflow = "scroll";
      // pass row id from table for updating user
      updateuserId?.setAttribute("value", `${btn.dataset.id}`);
      // load selected user
      const data = await ajaxRequest(`./getUser.php?userid=${+btn.dataset.id}`);
      // Fill update form
      if (updateUserForm)
        updateUserForm.querySelector(".username").value = data.username;
    });
  });

  // if action DELETE btn is pressed
  const deleteBtn = document.querySelectorAll(".user-delete-btn");
  const deleteModal = document.querySelector(".delete-modal");
  const deleteModalId = document.getElementById("delete-id");

  // attach and event listener to each delete button
  deleteBtn.forEach((btn) => {
    btn.addEventListener("click", () => {
      // show custom DELETE modal
      deleteModal?.classList.toggle("show-modal");
      // disable scrolling
      document.body.style.overflow = "hidden";
      // pass row id from table to custom DELETE modal input
      deleteModalId?.setAttribute("value", `${btn.dataset.id}`);
    });
  });
};
export { displayUsers };

// CREATE user
const createUser = () => {
  const newUserBtn = document.querySelector(".users .new-btn");
  const createUserModal = document.querySelector(".create-user-modal");
  const createUserForm = document.querySelector(".create-user-form");

  // show create user modal
  newUserBtn?.addEventListener("click", (e) => {
    e.preventDefault();
    createUserModal.classList.add("show");
    document.body.style.overflow = "hidden";
    createUserForm.reset();
  });

  // close create user modal when back is pressed
  const backButton = createUserModal?.querySelector(
    ".form-btn-container .form-back-btn"
  );
  backButton?.addEventListener("click", (e) => {
    e.preventDefault();
    createUserModal.classList.remove("show");
    document.body.style.overflow = "auto";

    // clear form fields
    createUserForm.reset();
  });

  // when form is SUBMITTED
  createUserForm.addEventListener("submit", async function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    try {
      const successData = await ajaxRequest("./createUser.php", {
        method: "POST",
        body: formData,
      });

      // close create user modal
      createUserModal.classList.remove("show");

      // enable scroll on body
      document.body.style.overflow = "auto";

      // show an ALERT message
      bogoAlert(successData.message, "bg-blue", 2);

      // load all users
      displayUsers();

      // clear form fields
      createUserForm.reset();
    } catch (error) {
      bogoAlert(error, "bg-red");
    }
  });
};
export { createUser };

// UPDATE user
const updateUser = () => {
  const updateBackButton = document.querySelector(
    ".update-user-form .form-back-btn"
  );
  const updateUserModal = document.querySelector(".update-user-modal");
  const updateUserForm = updateUserModal.querySelector(".update-user-form");

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
      const successData = await ajaxRequest("./updateUser.php", {
        method: "POST",
        body: formData,
      });

      if (successData.updated) {
        // close create user modal
        updateUserModal.classList.remove("show");

        // load all users
        displayUsers();

        // clear form fields
        updateUserForm.reset();
      }

      // show an ALERT message
      bogoAlert(
        successData.message,
        `${successData.updated ? "bg-green" : "bg-red"}`,
        2
      );
    } catch (error) {
      bogoAlert(error, "bg-red");
    }
  });
};
export { updateUser };

// DELETE user
const deleteUser = () => {
  const deleteModal = document.querySelector(".delete-modal");
  const deleteUserForm = document.querySelector(".delete-user-form");
  const deleteModalCancel = document.querySelector(".modal-cancel-btn");

  // if NO is selected in modal
  deleteModalCancel.addEventListener("click", () => {
    // hide custom DELETE modal
    deleteModal.classList.remove("show-modal");
    // enable scrolling
    document.body.style.overflow = "auto";
  });

  // if delete form is SUBMITTED
  deleteUserForm.addEventListener("submit", async (e) => {
    e.preventDefault(); // Prevent default form submission

    const form = e.target;
    const formData = new FormData(form);
    // Convert FormData to a plain JS object
    const deleteId = Object.fromEntries(formData);

    try {
      const successData = await ajaxRequest("./deleteUser.php", {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json", // Sending JSON
        },
        body: JSON.stringify(deleteId), // send data as JSON
      });

      // hide custom DELETE modal
      deleteModal.classList.remove("show-modal");
      // enable scrolling
      document.body.style.overflow = "auto";

      // show an ALERT message
      bogoAlert(successData.message, "bg-red", 2);

      // load all users
      displayUsers();
    } catch (error) {
      bogoAlert(error, "bg-red");
    }
  });
};
export { deleteUser };
