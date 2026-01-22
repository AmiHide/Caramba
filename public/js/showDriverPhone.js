function showDriverPhone(btn) {
    const block = btn.parentElement;
    const number = block.querySelector(".driver-phone-number");

    btn.style.display = "none";
    number.classList.remove("hidden");
    number.classList.add("fade-slide");
}
