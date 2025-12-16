const deleteUserModal = document.getElementById("deleteUserModal");
const confirmYes = document.getElementById("confirmDeleteUserYes");
const confirmNo = document.getElementById("confirmDeleteUserNo");

let deleteUserUrl = null;

document.querySelectorAll(".btn-delete-user").forEach(btn => {
    btn.addEventListener("click", function (e) {
        e.preventDefault();

        deleteUserUrl = this.getAttribute("href");

        deleteUserModal.style.display = "flex";
    });
});

confirmYes.addEventListener("click", () => {
    if (deleteUserUrl) {
        window.location.href = deleteUserUrl;
    }
});

confirmNo.addEventListener("click", () => {
    deleteUserModal.style.display = "none";
});
