const deleteTrajetModal = document.getElementById("deleteTrajetModal");
const confirmDeleteTrajetYes = document.getElementById("confirmDeleteTrajetYes");
const confirmDeleteTrajetNo = document.getElementById("confirmDeleteTrajetNo");

let deleteTrajetUrl = null;


document.querySelectorAll(".btn-delete-trajet").forEach(btn => {
    btn.addEventListener("click", function (e) {
        e.preventDefault();

        deleteTrajetUrl = this.getAttribute("href");

        deleteTrajetModal.style.display = "flex";
    });
});


confirmDeleteTrajetYes.addEventListener("click", () => {
    if (deleteTrajetUrl) {
        window.location.href = deleteTrajetUrl;
    }
});


confirmDeleteTrajetNo.addEventListener("click", () => {
    deleteTrajetModal.style.display = "none";
    });