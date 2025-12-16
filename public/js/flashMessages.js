document.addEventListener("DOMContentLoaded", () => {

    // Fermeture (avec la croix)
    document.querySelectorAll('.close-flash').forEach(btn => {
        btn.addEventListener('click', () => {
            const box = btn.parentElement;
            box.style.opacity = "0";
            setTimeout(() => box.remove(), 300);
        });
    });

    // Sinon fermeture automatique après X secondes
    setTimeout(() => {
        document.querySelectorAll('.flash-msg').forEach(msg => {
            msg.style.opacity = "0";
            setTimeout(() => msg.remove(), 300);
        });
    }, 4000);

});
