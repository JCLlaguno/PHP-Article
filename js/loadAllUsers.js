// LOAD all users
const loadAllUsers = async () => {
  try {
    const response = await fetch(`./loadAllUsers.php`);
    if (!response.ok) throw new Error(`HTTP error ${response.status}`);
    const data = await response.json();

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

    // if action UPDATE btn is pressed
    const actionUpdateBtn = document.querySelectorAll(".action-update-btn");
    const updateUserModal = document.querySelector(".update-user-modal");
    const updateUserForm = updateUserModal?.querySelector(".update-user-form");
    const updateuserId = updateUserForm?.querySelector("#update-user-id"); // id from UPDATE FORM
    // // if action UPDATE btn is CLICKED
    actionUpdateBtn.forEach((btn) => {
      btn.addEventListener("click", (e) => {
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
        loadUser(btn.dataset.id);
      });
    });

    // load a single user
    const loadUser = async (id) => {
      try {
        const response = await fetch("./getUser.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json", // Sending JSON
          },
          body: JSON.stringify({ userid: id }), // send data as JSON
        });

        if (!response.ok) throw new Error(`HTTP error ${response.status}`);

        const data = await response.json();

        // Fill form
        if (updateUserForm)
          updateUserForm.querySelector(".username").value = data.username || "";
      } catch (error) {
        console.error("Error loading article:", error);
      }
    };

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
  } catch (error) {
    console.error("Error loading user:", error);
  }
};

export { loadAllUsers };
