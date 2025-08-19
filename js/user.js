import { bogoAlert, loadUser, loadAllUsers } from "./helpers.js";

// DISPLAY all users
const displayUsers = async () => {
  const data = await loadAllUsers();
  const usersTable = document.querySelector(".users .users-table tbody");
  if (usersTable) usersTable.innerHTML = ""; // clear all existing rows
  data.forEach((user) => {
    const tr = document.createElement("tr");
    // LOAD data on users table
    tr.innerHTML = `
        <td data-title="Id">${user.id}</td>
        <td class="user-photo-container" data-title="Photo"><img class="user-photo" src="${user.photo}"></td>
        <td data-title="Username">${user.username}</td>
        <td data-title="Action">
            <div class="action-container">
                <a class="btn bg-green action-update-btn" data-id="${user.id}"><img src="./img/edit.svg" alt="Edit"></a>
                <a class="btn bg-red action-delete-btn user-delete-btn" data-id="${user.id}"><img src="./img/delete.svg" alt="Edit"></a>
            </div>
        </td>`;
    usersTable?.appendChild(tr);
  });

  // load total users on dashboard
  const usersCardContent = document.querySelector(
    ".dashboard .users-card-content"
  );
  if (usersCardContent)
    usersCardContent.textContent = `${Object.keys(data).length}`;

  // if action UPDATE btn is pressed
  const actionUpdateBtn = document.querySelectorAll(".action-update-btn");
  const updateUserModal = document.querySelector(".update-user-modal");
  const updateUserForm = updateUserModal?.querySelector(".update-user-form");
  const updateuserId = updateUserForm?.querySelector("#update-user-id"); // id from UPDATE FORM
  // // if action UPDATE btn is CLICKED
  actionUpdateBtn.forEach((btn) => {
    btn.addEventListener("click", async (e) => {
      e.preventDefault();

      // SHOW update user form
      updateUserModal?.classList.add("show");
      // disable scroll on body
      document.body.style.overflow = "hidden";
      // enable scroll on update modal
      if (updateUserModal) updateUserModal.style.overflow = "scroll";
      // pass row id from table to UPDATE form input
      updateuserId?.setAttribute("value", `${btn.dataset.id}`);
      // // load selected user
      const data = await loadUser(+btn.dataset.id);
      // Fill update form
      if (updateUserForm)
        updateUserForm.querySelector(".username").value = data.username || "";
    });
  });

  // if action delete btn is pressed
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

// LOAD a active user
const navUserPhoto = document.querySelector(".nav-user-photo");
const dashboardTitle = document.querySelector(".dashboard .dashboard-welcome");

const loadActiveUser = async () => {
  // call load user from helpers js
  const data = await loadUser("./getUser.php");
  // Display active user photo on nav
  navUserPhoto.setAttribute("src", `${data.photo}`);

  // Display active username on dashboard Welcome
  if (dashboardTitle)
    dashboardTitle.textContent = `Welcome! ${data.username
      .charAt(0)
      .toUpperCase()}${data.username.slice(1)}`;
};
export { loadActiveUser };

// CREATE user
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

    // clear form fields
    createUserForm.reset();
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
      displayUsers();

      // clear form fields
      createUserForm.reset();
    } catch (error) {
      alert(error.message);
    }
  });
};
export { createUser };

// UPDATE user
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
        throw new Error(errorData.message);
      }

      const successData = await response.json();

      // close create user modal
      updateUserModal.classList.remove("show");

      // show an ALERT message
      bogoAlert(successData.message, "bg-green", users);

      // load all users
      displayUsers();

      // clear form fields
      updateUserForm.reset();
    } catch (error) {
      alert(error);
    }
  });
};
export { updateUser };

// DELETE user
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
      displayUsers();
    } catch (error) {
      alert(error);
    }
  });
};
export { deleteUser };
