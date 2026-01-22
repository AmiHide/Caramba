function showPhone(btn) {

    const box = btn.closest(".phone-reveal");
    if (!box) return;

    const number = box.querySelector(".phone-number");
    if (!number) return;

    btn.style.display = "none";

    number.classList.remove("hidden");
    number.classList.add("fade-slide"); 
}