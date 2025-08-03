import { bogoAlert } from "./script.js";

const deleteArticle = () => {
  const deleteButton = document.querySelectorAll(".action-delete-btn");
  const deleteModal = document.querySelector(".delete-modal");
  const deleteModalContent = document.querySelector(".delete-modal-content");
  const deleteModalCancel = document.querySelector(".modal-cancel-btn");
  const deleteModalId = document.getElementById("delete-id");

  // if action delete btn is CLICKED
  deleteButton?.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      // show custom DELETE modal
      deleteModal?.classList.toggle("show-modal");
      // disable scrolling
      document.body.style.overflow = "hidden";
      // pass row id from table to custom DELETE modal input
      deleteModalId?.setAttribute("value", `${btn.dataset.id}`);
    });
  });

  // if NO is selected in modal
  deleteModalCancel?.addEventListener("click", (e) => {
    e.preventDefault();
    // hide custom DELETE modal
    deleteModal?.classList.remove("show-modal");
    // enable scrolling
    document.body.style.overflow = "auto";
  });

  // id YES is selected on modal
  deleteModalContent?.addEventListener("submit", async (e) => {
    e.preventDefault(); // Prevent default form submission

    // const deleteId = deleteModalId.value; // get ID from delete Modal
    const form = e.target;
    const formData = new FormData(form);
    // Convert FormData to a plain JS object
    const deleteId = Object.fromEntries(formData);

    try {
      const response = await fetch("deleteArticle.php", {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json", // Sending JSON
        },
        body: JSON.stringify(deleteId), // send data as JSON
      });

      if (!response.ok) throw new Error(await response.json().error);

      // find row containing the delete button
      const rowIndex = [...deleteButton].findIndex(
        (el) => +el.dataset.id === +deleteId["delete-id"]
      );
      const row = deleteButton[+rowIndex].closest("tr");

      // remove row
      row.remove();
      deleteModal?.classList.remove("show-modal");

      // enable scrolling
      document.body.style.overflow = "auto";

      const successData = await response.json();

      // show an ALERT message
      bogoAlert(successData.message, "bg-red");
    } catch (error) {
      alert(error);
    }
  });
};

export { deleteArticle };
