// LOAD all users
const loadAllUsers = async () => {
  try {
    const response = await fetch(`./loadAllUsers.php`);
    if (!response.ok) throw new Error(`HTTP error ${response.status}`);
    const data = await response.json();

    const usersTable = document.querySelector(".users .users-table tbody");
    data.forEach((user) => {
      // LOAD data on users table
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td data-title="Id">${user.id}</td>
        <td data-title="Username">${user.username}</td>
        <td data-title="Action">
            <div class="action-container">
                <a class="btn bg-green action-update-btn" data-id=""><img src="./img/edit.svg" alt="Edit"></a>
                <a class="btn bg-red action-delete-btn" data-id=""><img src="./img/delete.svg" alt="Edit"></a>
            </div>
        </td>`;
      usersTable.appendChild(tr);
      // add an EVENT listener to action buttons
    });
  } catch (error) {
    console.error("Error loading user:", error);
  }
};

export { loadAllUsers };
